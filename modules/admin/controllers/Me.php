<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Me extends AdminController {

	var $front_menu = '';
	function __construct()
	{
		parent::__construct(); 
		$this->_set_title( 'DASHBOARD' );
	}
	
	function set_theme(){
		$menu = $this->jCfg['theme_setting']['menu']=="top"?"left":"top";
		$this->sCfg['theme_setting']['menu'] = $menu;
		$this->_releaseSession();
		$go = isset($_GET['next'])?$this->input->get('next'):site_url('meme/me');
		redirect($go);	
	}

	function index(){ 
		$this->is_dashboard = true;
		$this->css_file[] = 'daterangepicker/daterangepicker-bs3.css';
		$this->js_plugins = array('plugins/daterangepicker/moment.min.js','plugins/daterangepicker/daterangepicker.js','plugins/sparkline/jquery.sparkline.min.js');
		$this->js_file[] = 'page/init.daterangepicker.js';

		$this->load->helper('dashboard');
		$data = array(
			"end" => isset($_GET['end'])?$this->input->get('end'):date("Y-m-d"),
			"start"	=> isset($_GET['start'])?$this->input->get('start'):mDate(date("Y-m-d"),"-1 week","Y-m-d"),
		);	

		$this->_v("index",$data);
	}

	function set_sentiment(){
        $s = $this->input->get('s');
        $id = $this->input->get('id');
        $next = $this->input->get('next');

        $this->db->update("app_stream_data",array(
        		"sentiment"	 	=> trim(strtolower($s)),
        		"is_sentiment"	=> 1
        	),array(
        		"id"		=> (int)$id
        	));

        if( trim($next)!="" ){
        	redirect($next);
        }else{
        	rdirect(site_url());
        }
    }

    function hapus_sentiment(){
        $id = $this->input->get('id');
        $next = $this->input->get('next');

        $this->db->delete("app_stream_data",array(
        		"id"		=> (int)$id
        	));

        if( trim($next)!="" ){
        	redirect($next);
        }else{
        	rdirect(site_url());
        }
    }

    function otomatis_sentiment(){
    	$this->load->helper('magic');
        $id = $this->input->get('id');
        $next = $this->input->get('next');

        $row = $this->db->get_where("app_stream_data",array(
        		"id"		=> (int)$id
        	))->row();

        $text_stemming = isset($row->text_stemming)?$row->text_stemming:'';

        $m = bayes(array(
                        "text" => $text_stemming
                    ));
        $sentiment = "netral";
        if( count($m) > 0 ){
	        $negatif = round($m['negatif']*100);
	        $positif = round($m['positif']*100);
	        if( ($positif - $negatif) > cfg('range_value') ){
	        	$sentiment = 'positif';
	        }

	        if( ($negatif - $positif) > cfg('range_value') ){
	        	$sentiment = 'negatif';
	        }
	    }

        $this->db->update("app_stream_data",array(
        		"sentiment"	 	=> trim(strtolower($sentiment)),
        		"is_sentiment"	=> 1
        	),array(
        		"id"		=> (int)$id
        	));

        if( trim($next)!="" ){
        	redirect($next);
        }else{
        	rdirect(site_url());
        }
    }



	function locked(){
		$data = array();
		$this->is_dashboard = TRUE;
		$this->_v("lockscreen",$data,false);
	}

	function daftar(){ 
		$data = array();
		$this->is_dashboard = TRUE;

		$this->_set_title( 'PENDAFTARAN KARTU ANGGOTA' );
		$this->_v("daftar",$data);
	}
	function profile(){
		$this->is_dashboard = TRUE;
		$this->_set_title('Profile of ( You ) '.$this->jCfg['user']['fullname']);
		$this->breadcrumb[] = array(
				"title"		=> "Profile"
			);
		$this->_v("view-profile",array(
			"data"	=> $this->db->get_where("app_user",array(
					"user_id"	=> $this->jCfg['user']['id']
				))->row()
		));

	}

	function edit_profile(){

		$this->is_dashboard = TRUE;
		$this->_set_title('Update Profile For ( You ) '.$this->jCfg['user']['fullname']);
		$this->breadcrumb[] = array(
				"title"		=> "Profile",
				"url"		=> $this->own_link
			);

		$this->breadcrumb[] = array(
				"title"		=> "Update Profile"
			);

		if( isset($_POST['update']) ){
			$this->DATA->table = "app_user";
			$data = array(
				'user_fullname'		=> dbClean($_POST['user_fullname']),
				'user_email'		=> dbClean($_POST['user_email']),
				'user_telp'			=> dbClean($_POST['user_telp']),
				'is_share'			=> dbClean($_POST['is_share']),
			);		
			$a = $this->_save_master( 
				$data,
				array(
					'user_id' => $this->jCfg['user']['id']
				),
				$this->jCfg['user']['id']		
			);

			$this->upload_path="./assets/collections/photo/";
			$id = $this->jCfg['user']['id'];
			$this->_uploaded(
			array(
				'id'		=> $id ,
				'input'		=> 'user_photo',
				'param'		=> array(
								'field' => 'user_photo', 
								'par'	=> array('user_id' => $id)
							)
			));
			redirect($this->own_link."/edit_profile?msg=".urldecode('Update data user succes')."&type_msg=success");
		}

		$this->_v("edit_profile",array(
			"val"	=> $this->db->get_where("app_user",array(
					"user_id"	=> $this->jCfg['user']['id']
				))->row()
		));

	}

	function template(){
		$this->upload_path = cfg('upload_path_brand');
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);

		$this->breadcrumb[] = array(
				"title"		=> "Manage Brand",
				"url"		=> $this->own_link
			);

		$this->is_dashboard = false;

		if(isset($_POST['btn_simpan'])){
			$this->DATA->table="web_brand";
			$data = array(
				'brand_name'				=> $this->input->post('brand_name'),
				'brand_fullname'			=> $this->input->post('brand_fullname'),
				'brand_bg_show'				=> isset($_POST['brand_bg_show'])?1:0,
				'brand_logo_show'			=> isset($_POST['brand_logo_show'])?1:0,
				'brand_cp_name'				=> $this->input->post('brand_cp_name'),
				'brand_cp_email'			=> $this->input->post('brand_cp_email'),
				'brand_desc'				=> $this->input->post('brand_desc'),
				'brand_front_title'			=> $this->input->post('brand_front_title'),
				'brand_front_desc'			=> $this->input->post('brand_front_desc')
			);		
			$a = $this->_save_master( 
				$data,
				array(
					'brand_id' => $this->jCfg['user']['brand']
				),
				dbClean($this->jCfg['user']['brand'])			
			);
			
			$id = $this->jCfg['user']['brand'];
			$this->_uploaded(
	        array(
	            'id'        => $id ,
	            'input'     => 'brand_logo',
	            'param'     => array(
	                            'field' => 'brand_logo', 
	                            'par'   => array('brand_id' => $id)
	                        )
	        ));
	        
	        $this->_uploaded(
	        array(
	            'id'        => $id ,
	            'input'     => 'brand_bg',
	            'param'     => array(
	                            'field' => 'brand_bg', 
	                            'par'   => array('brand_id' => $id)
	                        )
	        ));

		}

		$brand = $this->db->get_where("web_brand",array(
				"brand_id" => $this->jCfg['user']['brand']
			))->row();

		$this->jCfg['user']['template_brand']['bg'] 	= $this->sCfg['user']['template_brand']['bg'] = $brand->brand_bg;
		$this->jCfg['user']['template_brand']['logo'] 	= $this->sCfg['user']['template_brand']['logo'] = $brand->brand_logo;
		$this->_releaseSession();

		$this->_set_title('Manage  Brand '.$brand->brand_name);
		$this->_v("template",array(
				"val"	=> $brand
			));

	}
	function change_password(){
		$this->breadcrumb[] = array(
				"title"		=> "Change Password",
				"url"		=> $this->own_link
			);

		$this->is_dashboard = false;
		$pesan="";
		if(isset($_POST['btn_simpan'])){
			$pass_lama = md5(dbClean($_POST['old_pass']));
			$this->DATA->table="app_user";
			$m1 = $this->DATA->_getall(array(
				"user_name"		=> $this->jCfg['user']['name'],
				"user_password"	=> $pass_lama
			));

			if(count($m1)>0){
				$pass_baru = md5(dbClean($_POST['new_pass']));
				$mx = $this->DATA->_update(
					array(
						"user_name"		=> $this->jCfg['user']['name']
					),array(
						"user_password" => $pass_baru
					)

				);
				$pesan = ($mx)?"Success update your password":"Success update your password";
				$mtype = ($mx)?"success":"error";
			}else{
				$pesan ="Your old password is not correctly!";
				$mtype = "error";
			}

			redirect($this->own_link."/change_password?msg=".urldecode($pesan)."&type_msg=".$mtype);
		}

		
		$this->_set_title('Change Password For ( You ) '.$this->jCfg['user']['fullname']);
		$this->_v("change-password",array(
			"pesan"	=> $pesan
		));
	}

	function bug(){
		if(isset($_POST['btn_simpan'])){
			$pesan = dbClean($_POST['pesan']);
			$url   = isset($_GET['url'])?$_GET['url']:'';
			$by    = $this->jCfg['user']['name'];
			$tgl   = date("Y-m-d H:i:s");
			$msg   = "Telah Terjadi Error Pada ".$tgl." Dilaporkan Oleh : ".$by."\n";
			$msg  .= "Error Pada ".$url." \n Pesan : ".$pesan."\n";

			$this->sendEmail(array(
				'from'		=> 'web@'.$this->domain,
				'to'		=> array(getCfgApp('bug_email')),
				'subject'	=> 'Bolanews Bug',
				'priority'	=> 1,
				'message'	=> $msg
			));

			echo "<script>parent.location.reload(true);</script>";
		}

		$this->_v("report_bug",array(
			"url"	=> isset($_GET['url'])?$_GET['url']:''
		),FALSE); 
	}	


	function help(){
		if( isset($_GET['page']) && trim($_GET['page'])!="" ){
			$this->_v("help/".$_GET['page'],array());
		}else{
			$this->_v("help/index",array());
		}
	}
	
	function meme(){
		redirect(site_url('admin/me'));
	}
}



