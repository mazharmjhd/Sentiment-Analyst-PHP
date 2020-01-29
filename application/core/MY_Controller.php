<?php 
include("globalModel.php");
class MY_Controller extends CI_Controller{ 
	
	var $DATA;
	var $upload_path	= './assets/files/';
	var $upload_allowed_types	= 'gif|jpeg|jpg|png|avi|mp4|mpeg|mpg|movie|mov|qt|flv';
	var $upload_types	= 'image';	// image or file.
	var $upload_resize  = array(
				array('name'	=> 'thumb','width'	=> 70, 'height'	=> 70, 'quality'	=> '100%'),
				array('name'	=> 'medium','width'	=> 200, 'height'	=> 200, 'quality'	=> '100%')
			);
	var $message = "";
	var $folder_view = "";
	var $prefix_view = "";
	var $per_page 		= 20;
	var $uri_segment 	= 4;
	var $domain = "";
	var $data_table; 
	var $user_online = array();
	var $sCfg = array();

	var $js_file = array();
	var $css_file = array();
	var $js_script = array();
	var $js_plugins = array();
	var $is_search_date = true;
	var $site_info = array();
	var $xjs_file = array();

	function __construct(){  
 
		parent::__construct();  		  
		date_default_timezone_set('Asia/Jakarta');
		
		$this->_initConfig();
		//$this->_initSession();		
		$this->output->enable_profiler(false);
		$this->DATA = new globalModel();		

		$this->domain = $_SERVER['SERVER_NAME'];
		if( cfg('activeLog')==true )
			$this->write_log();
	}
	
	function _initConfig(){

		$s = $this->session->userdata("init");
		if($s==true){
			$this->jCfg = $this->session->userdata;
		}else{
			$this->_initSession();			
		}
	}
	
	function isLogin(){
		if($this->jCfg['is_login'] == 1){
			redirect('');
		}else{
			redirect('auth');
		}
	}
	
	function current_session($i=0){
		for($x=0;$x>=$i;$x++){
			$this->_initSession();
		}
	}
	
	function _initSession(){
		$init_param = array(
			'init'			=> true,			
			'app_id'		=> '1',
			'app_name'		=> '',
			'referal_id'	=> 0,
			'referal_code'	=> '',
			'is_login'		=> 0,
			'radius'		=> array(),
			'template_brand'=> array(
				'logo'	=> '',
				'bg'	=> ''
			),
			'user' => array(
				'id' 		=> '',
				'saldo'		=> 0,
				'name'		=> 'guest',
				'fullname'	=> 'Guest',
				'level'		=> '',
				'brand'		=> 0,
				'image'		=> '',
				'section'	=> 0,
				'role'		=> array(),
				'is_all'	=> 0,
				'color'		=> 'mine',
				'bg'		=> 'ptrn_e',
				'email'		=> ''
			),
			'current_class'		=> '',
			'current_funtion' 	=> '',
			'mod_rewrite'	=> 1,
			'theme'			=> '',
			'referer'		=> '',
			'chat_online'	=> array(),
			'theme_setting' 	=> array(
					"menu"		=> "top",
					"header"	=> true,
					"position"	=> "relative",
					"color"		=> "#FE4A3F"
				),
			'lang'			=> 'ind',
			'member'		=> array(
						'id'		 => 0,
						'is_login'	 => 0,
						'login_type' => '',
						'name'		 => '',
						'uid'		 => '',
						'email'		 => '',
						'token'		 => ''
				),
			'captcha'		=> array()			
		);
		$this->_releaseSession($init_param);
	}
	
	function setReferer($url=''){
		$this->sCfg['referer'] = $url;
		$this->_releaseSession();
	}
	
	function setMessage($message=''){
		$this->sCfg['message'] = $message;
		$this->_releaseSession();
	}
	
	
	function setLang($lang='eng'){
		$this->sCfg['lang'] = $lang;
		$this->_releaseSession();
	}

	function getReferer(){
		return $this->jCfg['referer'];
	}
	
	function _set_userdata($param=array()){
		$this->session->set_userdata($param);
	}

	function _releaseSession($param=array()){

		if( count($param) >  0){
			foreach ((array)$param as $k => $v) {
				$this->_set_userdata(array(
						$k=>$v
					));
			}
		}else{
			if( count($this->sCfg) > 0 ){
				foreach ((array)$this->sCfg as $p => $q) {
					if( !is_array($q) || ( is_array($q) && count($q)==0 ) ){
						$this->_set_userdata(array(
							$p=>$q
						));
					}else{

						if(!isset($this->jCfg[$p])){
							$this->_set_userdata(array(
								$p=>$q
							));	
						}else{

							$tmp = $this->jCfg[$p];
							foreach ((array)$q as $k1 => $v1) {
								$tmp[$k1] = $v1;
							}
							$this->_set_userdata(array(
								$p=>$tmp
							));	
						}
					}
				}
			}
		}
	}
	
	/*
	* stuff function
	*/
	function _getClass(){ // return name of current class
		return $this->router->fetch_class();
	}
	
	function _getMethod(){ // return name of current methode
		return $this->router->fetch_method();
	}

	
	function sendEmail($p=array()){
		$this->load->library('email');
		/*mail method */
		$config['protocol'] = 'mail';
		$config['mailtype'] = isset($p['type'])?$p['type']:'html';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['priority'] = isset($p['priority'])?$p['priority']:3; 
		
		/*smtp method */
		/*$config['protocol']  = 'mail';
		$config['smtp_host'] = 'smtp.gmail.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = 'hhumaedi@gmail.com';
		$config['smtp_pass'] = '*****';
		$config['priority']  = 1;
		$config['mailtype']  = 'html';
		$config['charset']   = 'utf-8';
		$config['wordwrap']  = TRUE;*/
		
		/* send mail method */ 
		/*$config['protocol'] = 'sendmail';
		$config['mailtype'] = 'html';
		$config['charset']  = 'utf-8';
		$config['wordwrap'] = TRUE;
		*/
		$this->email->initialize($config);

		$this->email->from($p['from'], isset($p['title'])?$p['title']:'Hondacommunity');
		$this->email->to($p['to']);
		if( isset($p['cc']) && trim($p['cc']) != "" ){			
			$this->email->cc($p['cc']); 
		}
		$this->email->subject('Hondacommunity : '.$p['subject']);
		$this->email->message($p['message']);
		
		if(isset($p['alt_message']) && trim($p['alt_message'])!='' ){
			$this->email->set_alt_message($p['alt_message']);
		}
		
		$this->email->send();
		//debugCode($this->email->print_debugger());
		
	}

	function _uploaded($par=array()){
				
		$this->load->library('image_lib');
		$uri = $this->upload_path;		
		$folder_upload = (isset($par['folder']))?$par['folder']:'';
		if($_FILES[$par['input']]['error']==4)
			return false;
		
		$uId = uniqid();
		$fileName = $uId;
		
		$folder_upload = trim($folder_upload)!=""?$folder_upload."/":"";
		$config['upload_path'] = $uri.$folder_upload;
		$config['file_name'] = $fileName;
		$config['allowed_types'] = $this->upload_allowed_types;
		$config['max_size']		= 1024*20;
		if(trim($this->upload_types)=='image'){
			$config['max_width']  	= 1024*5;
			$config['max_height'] 	= 768*5;
		}
		$this->load->library('upload');
		$this->upload->initialize($config);

		if( $this->upload->do_upload($par['input']) )
		{	
			$data_upload = $this->upload->data();
			$img = $data_upload['file_name'];
			$this->_delte_old_files($par['param']);
			$this->DATA->_update($par['param']['par'],array($par['param']['field']=>$img));
		}
		else {
			return ($this->upload->display_errors());
		}
	}

	function _delte_old_files($par=array()){
		$uri = $this->upload_path;
		$files = $this->DATA->data_id($par['par']);
		$folder = isset($par['folder'])?$par['folder'].'/':'original/';
		if( !empty( $files->{$par['field']} ) ){
			$ori_file = $uri.$folder.$files->{$par['field']};
			if(file_exists($ori_file)){
				unlink($ori_file);
			}
			if(trim($this->upload_types)=='image' && count($this->upload_resize) > 0){				
				$data = array();
				foreach($this->upload_resize as $m){
					$data[] = $uri.$m['name']."/".$files->{$par['field']};
				}	
				foreach($data as $v){
					if(file_exists($v)){
						unlink($v);
					}
				}
			}				
		}
	}	
	
	function _data($m=array()){
		
		$this->load->library('pagination');
		$config['per_page'] = $this->per_page;
		$data = $this->data_table;
		$config['base_url'] = $m['base_url'];
		$config['total_rows'] = $data['total'];		
		$config['uri_segment'] = $this->uri_segment;
		$config['suffix']	= $this->config->item('url_suffix');
		$config['full_tag_open'] = '<div class="row"><ul class="pull-right pagination">';
		$config['full_tag_close'] = '</ul></div>';	
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-chevron-right"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		return array(
			'data'			=>	$data['data'],			
			'cRec'			=>  $data['total'],
			'no'			=>  $this->uri->segment($this->uri_segment)==''?0:$this->uri->segment($this->uri_segment),
			'cPage'			=>  ceil($data['total']/$this->per_page),
			'paging'		=> 	$this->pagination->create_links()
		);		
	}

	function _data_web($m=array()){
		
		$this->load->library('pagination');
		$config['per_page'] = $this->per_page;
		$data = $this->data_table;
		$config['base_url'] = $m['base_url'];
		$config['total_rows'] = $data['total'];		
		$config['uri_segment'] = $this->uri_segment;
		$config['suffix']	= $this->config->item('url_suffix');
		$config['full_tag_open'] = '<nav><ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul></nav>';	
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link'] = '&larr;';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		return array(
			'data'			=>	$data['data'],			
			'cRec'			=>  $data['total'],
			'no'			=>  $this->uri->segment($this->uri_segment)==''?0:$this->uri->segment($this->uri_segment),
			'cPage'			=>  ceil($data['total']/$this->per_page),
			'paging'		=> 	$this->pagination->create_links()
		);		

	}

	function write_log(){
		
		$class 	= $this->_getClass();
		$method	= $this->_getMethod();
		$name	= $this->jCfg['user']['name'];
		$id 	= $this->jCfg['user']['id'];
		$ip		= $_SERVER['REMOTE_ADDR'];
		$browser= $_SERVER['HTTP_USER_AGENT'];
		$url 	= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$flag_ins = TRUE;
		if( (!isset($this->jCfg['current_class'])) && (!isset($this->jCfg['current_funtion'])) ){
			$this->sCfg['current_class'] = $class;
			$this->sCfg['current_funtion'] = $method;
			$this->_releaseSession();
		}else{
			
			if($this->jCfg['current_class']==$class && $this->jCfg['current_funtion']==$method){
				$flag_ins = FALSE;				
			}
			
			$this->sCfg['current_class'] = $class;
			$this->sCfg['current_funtion'] = $method;
			$this->_releaseSession();
		}
		
		if(!empty($id) && $flag_ins==TRUE && $this->jCfg['current_class']!="chat" ){
			
			$POST=isset($_POST)?json_encode($_POST):"";
			$GET=isset($_GET)?json_encode($_GET):"";
			$arr_method = array(
				"detail_member","detail_advertiser","cek_advertiser_username",
				"search","get_ads","detail_iklan","get_tag","report","get_tag",
				"get_tag_brand","get_reach","detail","get_ads_info","view_image",
				"get_city","test","index","im_lost","access"
			);
			if(!in_array($method,$arr_method)){
				$this->db->insert("app_log",array(
					"log_date"		=> date("Y-m-d H:i:s"),
					"log_class"		=> $class,
					"log_function" 	=> $method,
					"log_url"		=> $url,
					"log_user_id"	=> $id,
					"log_ip"		=> $ip,
					"log_role"		=> $this->jCfg['user']['level'],
					"log_user_agent"	=> $browser,
					"log_user_name"	=> $name,
					"log_var_get"	=> $GET,
					"log_var_post"	=> $POST			
				));
			}
		}
	}
	
}