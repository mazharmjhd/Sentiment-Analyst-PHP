 <?php
function stemming($p=array()){
	$CI = getCI();
	
	$output = "";

	if( isset($p['text']) && trim($p['text'])!="" ){
		require_once APPPATH.'libraries/sastrawi/vendor/autoload.php';

		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();

		$text = strip_tags($p['text']); //rmeove tag html
		$text = remove_emoji($text); //rmeove emoji html
		$text = remove_user($text);// remove user
		$text = make_links_blank($text); // remove link
		$text = str_replace("rt ", "", strtolower($text)); // remove rt
		$output   = cek_singkatan(array(
				"text" => $stemmer->stem($text)
			));
	}

	return $output;
}

function dl($url=""){
    $store_to = './assets/collections/profile/';
    
    $ex = explode("/", $url);
    $file_name = $ex[count($ex)-1];
    $url_img = $store_to.$file_name;
    if( !file_exists($url_img) ){
    	file_put_contents($url_img, fopen($url, 'r'));
    }
    return str_replace("./", base_url(), $url_img);
}
    
function crawl($p=array()){
	
	$CI = getCI();

	$keyword 	= trim($p['keyword'])==""?"Ujian Nasional":trim($p['keyword']);
	$limit 		= $p['limit'];
	if( trim($keyword) == "" ){
		die('No Keyword');
	}
	$limit = trim($limit)==""?50:$limit;

	// function crawl
	require_once(APPPATH.'/libraries/twitteroauth/twitteroauth.php');
	// twitter developer
	$consumer_key 		= cfg('tw_app_id');
	$consumer_secret 	= cfg('tw_app_secret');
	$oauth_token 		= '2578129488-lttHMS0PcGxbRfXsD2X3A1z3vPaQygOdyYQugS8';
	$oauth_token_secret = 'tkKXDfTk1znNaASvHzmkK99PXTkNo1zGMQ5y1e56cuxor';

	

	$connection = new TwitterOAuth(
					   $consumer_key, 
					   $consumer_secret,
 		 			   $oauth_token, 
		 			   $oauth_token_secret
		 		);
				 			 
	$method = 'search/tweets';
			
	$parameters = array(
		'q' 		=> $keyword,
		'count'		=> $limit
	);

	//data twitter -> import ke database
	$m = $connection->get($method,$parameters);
	//debugCode($m);
	$success=0;
	if( isset($m->statuses) && count($m->statuses) > 0 ){
		foreach ((array)$m->statuses as $k => $v) {
			// cek..
			 $cek = $CI->db->get_where("app_stream_data",array(
				 "status_id" 	=> $v->id_str,
				 "type"			=> "twitter"
			 ))->num_rows();
			 if( $cek == 0 ){
				  
				
			 	 //$url_new_img = $v->user->profile_image_url;	
			 	 $url_new_img = dl($v->user->profile_image_url);	    
			 	 $txt_stemming = stemming(array("text"=>$v->text));
				 $data_insert = array(
				 	"status_id" 	=> $v->id_str,
					"keyword"		=> $keyword,
					"type"			=> "twitter",
				 	"time_add"		=> date("Y-m-d H:i:s"),
				 	"create_date" 	=> $v->created_at,
				 	"text" 			=> $v->text,
				 	"text_stemming" => $txt_stemming,
				 	"url" 			=> 'https://twitter.com/'.$v->user->screen_name.'/status/'.$v->id_str,
				 	"user_id" 		=> $v->user->id_str,
				 	"user_screen_name" 	=> $v->user->screen_name,
				 	"user_name" 	=> $v->user->name,
				 	"foto" 			=> $url_new_img
				 );
				 $CI->db->insert("app_stream_data",$data_insert);
				 $success++;
			 }
		}
	}


	debugCode("jumlah yang berhasil di input ".$success);
			 	 
}

function cek_singkatan($p=array()){
	$CI = getCI();

	$return = "";

	if( isset($p['text']) && trim($p['text'])!="" ){
		$arr = explode(" ", $p['text']);
		$new_array = array();
		foreach ((array)$arr as $k => $v) {
			$m = $CI->db->get_where("app_singkatan",array(
					"sk_singkatan" => $v
				));
			if( $m->num_rows() > 0 ){
				$data_m = $m->row();
				$v = $data_m->sk_panjang;
			}
			$new_array[] =  strtolower($v);
		}

		$return = implode(" ", array_unique($new_array));
	}

	return $return;
}

function bayes($p=array()){

	$CI = getCI();
	
	$output = array();

	if( isset($p['text']) && trim($p['text'])!="" ){
		require_once APPPATH.'libraries/bayes/vendor/autoload.php';

		$tokenizer = new HybridLogic\Classifier\Basic;
		$classifier = new HybridLogic\Classifier($tokenizer);

		$positif = get_sample_stream(array(
				"sentiment" => "positif"
			));

		$negatif = get_sample_stream(array(
				"sentiment" => "negatif"
			));

		/*$netral = get_sample_stream(array(
				"sentiment" => "netral"
			));*/

		foreach ((array)$positif as $k1 => $v1) {
			$classifier->train('positif', $v1->text_stemming);
		}

		foreach ((array)$negatif as $k1 => $v1) {
			$classifier->train('negatif', $v1->text_stemming);
		}

		/*foreach ((array)$netral as $k1 => $v1) {
			$classifier->train('netral', $v1->text_stemming);
		}*/

		//train dari config
		$kamus_negatif = cfg('kamus_negatif');

		$kamus_positif = cfg('kamus_positif');
		if( trim($kamus_positif)!="" ){
			$arr_kamus_positif = explode(",", $kamus_positif);
			foreach ((array)$arr_kamus_positif as $p_value) {
				$classifier->train('positif', $p_value);
			}
		}

		if( trim($kamus_negatif)!="" ){
			$arr_kamus_negatif = explode(",", $kamus_negatif);
			foreach ((array)$arr_kamus_negatif as $n_value) {
				$classifier->train('negatif', $n_value);
			}
		}

		$output = $classifier->classify($p['text']);

	}

	return $output;

}

function get_sample_stream($p=array()){
	$CI = getCI();

	$CI->db->select("text_stemming");
	$CI->db->order_by("id","DESC");
	return $CI->db->get_where("app_stream_data",array(
			"sentiment" => $p['sentiment']
		))->result();
}

function make_links_blank($text)
{
  $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
  return preg_replace($regex, ' ', $text);
}

function remove_user($text)
{
 	 return preg_replace('/@([A-Za-z0-9_]{1,15})/', '', $text);

}

function remove_emoji($text){
      return preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $text);
}

