<?php
include_once(APPPATH."libraries/FrontController.php");
class Cron extends FrontController {
	function __construct()  
	{
		parent::__construct(); 	
		$this->load->helper('magic');	

	}  
	function index()  
	{
		die(' Hi.. ');
	}

	//

	function ig(){
		$keyword = "VirusCorona";
		$url = 'https://www.instagram.com/explore/tags/'.$keyword.'/?__a=1';
		$m = file_get_contents($url);
		//$m = json_encode($m);
		$m = json_decode($m,FALSE);

		debugCode($m);
		$data = array();
		$success = 0;
		if( isset($m->entry) ){
			for($i=0;$i<count($m->entry);$i++){
				$data[] = $par = array(
					"id" => $m->entry[$i]->id,
					"title" => $m->entry[$i]->title,
					"content" => $m->entry[$i]->content,
					"date" => myDate($m->entry[$i]->published,"Y-m-d H:i:s",false),
					"link" => $m->entry[$i]->link->{'@attributes'}->href
				);

				$cek = $this->db->get_where("app_stream_data",array(
					"status_id" 	=> $par['id'],
					"type"			=> "instagram"
				))->num_rows();
				if( $cek == 0 ){
					 
					$url_new_img = "";	    
					$txt_stemming = stemming(array("text"=>$par['title']));
					$data_insert = array(
						"status_id" 	=> $par['id'],
					   "keyword"		=> $keyword,
					   "type"			=> "instagram",
						"time_add"		=> date("Y-m-d H:i:s"),
  						"create_date" 	=> $par['date'],
						"text" 			=> $par['title'],
						"text_stemming" => $txt_stemming,
						"url" 			=> $par['link'],
						"user_id" 		=> 'website',
						"user_screen_name" 	=> 'website',
						"user_name" 	=> 'website',
						"foto" 			=> base_url().'/assets/collections/user/profile-kosong.png'
					);
					$this->db->insert("app_stream_data",$data_insert);
					$success++;
				}

			}
		}
		
		die("Total Insert Data : ".$success);
		
		//debugCode($data);
		
	}

	function google_alert(){
		$keyword = "Banjir";
		$url = 'https://www.google.co.id/alerts/feeds/05526403133428080829/6742372131767769020';
		$m = simplexml_load_file($url);
		$m = json_encode($m);
		$m = json_decode($m,FALSE);

		//debugCode($m);
		$data = array();
		$success = 0;
		if( isset($m->entry) ){
			for($i=0;$i<count($m->entry);$i++){
				$data[] = $par = array(
					"id" => $m->entry[$i]->id,
					"title" => $m->entry[$i]->title,
					"content" => $m->entry[$i]->content,
					"date" => myDate($m->entry[$i]->published,"Y-m-d H:i:s",false),
					"link" => $m->entry[$i]->link->{'@attributes'}->href
				);

				$cek = $this->db->get_where("app_stream_data",array(
					"status_id" 	=> $par['id'],
					"type"			=> "news"
				))->num_rows();
				if( $cek == 0 ){
					 
 					$url_new_img = "";	    
					$txt_stemming = stemming(array("text"=>$par['title']));
					$data_insert = array(
						"status_id" 	=> $par['id'],
					   "keyword"		=> $keyword,
					   "type"			=> "news",
						"time_add"		=> date("Y-m-d H:i:s"),
						"create_date" 	=> $par['date'],
						"text" 			=> $par['title'],
						"text_stemming" => $txt_stemming,
						"url" 			=> $par['link'],
						"user_id" 		=> 'website',
						"user_screen_name" 	=> 'website',
						"user_name" 	=> 'website',
						"foto" 			=> base_url().'/assets/collections/user/profile-kosong.png'
					);
					$this->db->insert("app_stream_data",$data_insert);
					$success++;
				}

			}
		}
		
		die("Total Insert Data : ".$success);
		
		//debugCode($data);
		
	}

	function facebook(){
		$keyword = "banjir";
		$url = 'https://m.facebook.com/search/top/?q=banjir&refid=7&_rdc=1&_rdr';
		$m = simplexml_load_file($url);
		$m = json_encode($m);
		$m = json_decode($m,FALSE);

		//debugCode($m);
		$data = array();
		$success = 0;
		if( isset($m->entry) ){
			for($i=0;$i<count($m->entry);$i++){
				$data[] = $par = array(
					"id" => $m->entry[$i]->id,
					"title" => $m->entry[$i]->title,
					"content" => $m->entry[$i]->content,
					"date" => myDate($m->entry[$i]->published,"Y-m-d H:i:s",false),
					"link" => $m->entry[$i]->link->{'@attributes'}->href
				);

				$cek = $this->db->get_where("app_stream_data",array(
					"status_id" 	=> $par['id'],
					"type"			=> "facebook"
				))->num_rows();
				if( $cek == 0 ){
					 
 					$url_new_img = "";	    
					$txt_stemming = stemming(array("text"=>$par['title']));
					$data_insert = array(
						"status_id" 	=> $par['id'],
					   "keyword"		=> $keyword,
					   "type"			=> "news",
						"time_add"		=> date("Y-m-d H:i:s"),
						"create_date" 	=> $par['date'],
						"text" 			=> $par['title'],
						"text_stemming" => $txt_stemming,
						"url" 			=> $par['link'],
						"user_id" 		=> 'facebook',
						"user_screen_name" 	=> 'facebook',
						"user_name" 	=> 'facebook',
						"foto" 			=> base_url().'/assets/collections/user/profile-kosong.png'
					);
					$this->db->insert("app_stream_data",$data_insert);
					$success++;
				}

			}
		}
		
		die("Total Insert Data : ".$success);
		
		//debugCode($data);
		
	}
	function test_bayes(){
		$text = $this->input->get('text');
		if( isset($text) && trim($text)!="" ){
			require_once APPPATH.'libraries/bayes/vendor/autoload.php';
	
			$tokenizer = new HybridLogic\Classifier\Basic;
			$classifier = new HybridLogic\Classifier($tokenizer);

			$classifier->train('positif', 'Mobilenya cepet banget');
			$classifier->train('positif', 'Mobilenya bagus banget');
			$classifier->train('positif', 'Motornya enak dipakenya');

			$classifier->train('negatif', 'Mobilenya lambat banget');
			$classifier->train('negatif', 'Mobilenya jelek banget');
			$classifier->train('negatif', 'Motornya rusak');

			$output = $classifier->classify($text);

			debugCode($output);
		}
	}
	function crawl(){
		// keyword
		echo '<!DOCTYPE html>
		<html lang="en">
		<head>
		<meta charset="utf-8">
		<title>CRAWL</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Refresh" content="60" /></head><body>';
		$keyword = $this->input->get('q');
		// limit jumlah data
		$limit = $this->input->get('limit');

		$m = crawl(array(
				"keyword" => $keyword,
				"limit" => $limit
			));

		debugCode($m,false);
		echo '</body>';
		echo '</html>';
	}

	function stem(){
		$m = stemming(array(
				"text" => $this->input->get('text')
			));
		$result = array(
				"status" => true,
				"data" => array(
					"original" => $this->input->get('text'),
					"stemming" => $m
				)
			);
		die(json_encode($result));
	}

	function bayes(){
		$m = bayes(array(
				"text" =>  $this->input->get('text')
			));
		
		die(json_encode($m));
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */