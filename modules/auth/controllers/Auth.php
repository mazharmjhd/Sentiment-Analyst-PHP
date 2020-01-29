<?php
include_once(APPPATH."libraries/FrontController.php");
class Auth extends FrontController {
	function __construct()  
	{
		parent::__construct(); 		
		$this->jCfg['theme'] = 'admin/'.cfg('template_admin');

	}
	function index()  
	{
		if(isset($this->jCfg['is_login']) && $this->jCfg['is_login']==1){
			redirect(site_url("admin/me"));
		}
		$data = array(
			'message'=>''
		);
		$this->_v('login',$data);
	}
	
	function act_auth(){
		if(isset($_POST['login'])){
			$u = $this->input->post('username');
			$p = md5($this->input->post('password'));
			if( trim($u) == '' || trim($p) == '' ){
				$status = array(
						"status"	=> 0,
						"data"		=> array(),
						"message"	=> 'Please input your username and password'
					);
				die(json_encode($status));
			}else{
				$d = $this->db->get_where("app_user",array(
						"user_name"		=> $u,
						"user_password"	=> $p,
						"user_status"	=> 1,
						"is_trash"		=> 0
					))->row();

				if(count($d) > 0){					
					/*set session*/

					$group = $this->db->get_where("app_user_group",array(
							"ug_user_id" => $d->user_id
						))->result();
					
						
					$arr_group = array();
					foreach ((array)$group as $p => $q) {
						$arr_group[] = $q->ug_group_id;
					}
					$this->sCfg['is_login'] 		= 1;
					$this->sCfg['user']['id'] 		= $d->user_id;
					$this->sCfg['user']['name']		= $d->user_name;
					$this->sCfg['user']['image']	= get_image(base_url()."assets/collections/user/".$d->user_photo);
					$this->sCfg['user']['fullname'] = $d->user_fullname;
					$this->sCfg['user']['is_all']	= $d->is_show_all;	
					$this->sCfg['user']['role'] 	= $arr_group;											
			
					$this->_releaseSession();

					$this->db->update("app_user",array(
						'user_logindate' => date("Y-m-d H:i:s")
					),array(
						'user_id' => $d->user_id
					));
					
					$go_to = site_url('admin/me');				

					$status = array(
						"status"	=> 1,
						"data"		=> array(
								"go_to"	=> $go_to
							),
						"message"	=> 'Login berhasil, loading....'
					);
					die(json_encode($status));

				}else{
					$status = array(
						"status"	=> 0,
						"data"		=> array(),
						"message"	=> 'Silahkan cek username dan password'
					);
					die(json_encode($status));
				}
			}		
		}	
	}

	function out(){
		$this->sCfg['user']['id'] 		= '';
		$this->sCfg['user']['fullname'] = 'Guest';
		$this->sCfg['user']['name'] 	= 'guest';
		$this->sCfg['user']['level'] 	= '';
		$this->sCfg['user']['user_type'] 	= '';
		$this->sCfg['user']['access'] 	= array();
		$this->sCfg['menu'] 			= array();
		$this->sCfg['is_login'] 		= 0;
		$this->sCfg['user']['is_all']	= 0;
		$this->sCfg['user']['role'] 	= array();	
		$this->sCfg['user']['bg']		= 0;
		$this->sCfg['referer']			= "";
		$this->_releaseSession();
		redirect(site_url('auth'));
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */