<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class User extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title('Manage User Login');
		$this->DATA->table="app_user";
		$this->folder_view = "meme/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->upload_path=cfg('upload_path_user')."/";

		$this->breadcrumb[] = array(
				"title"		=> "User",
				"url"		=> $this->own_link
			);

		if(!isset($this->jCfg['search']) || !isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''						=> 'All',
			'user_fullname'			=> 'Full Name',
			'user_email'			=> 'Email'
		); 
		$this->load->model("mdl_meme","M");
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
	}
	
	function cek_user(){
		echo _ajax_cek(array(
			"field" => "user_name",
			"table"	=> "iapi_user"
		));
	}
	
	function _reset(){
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'name'		=> 'user',
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'user_id',
			'order_dir' => 'DESC',
			'colum'		=> '',
			'keyword'	=> ''
		);
		$this->_releaseSession();
	}

	function index(){
	

		$this->breadcrumb[] = array(
				"title"		=> "List"
			);
		if($this->input->post('btn_search')){
			if($this->input->post('date_start') && trim($this->input->post('date_start'))!="")
				$this->jCfg['search']['date_start'] = $this->input->post('date_start');

			if($this->input->post('date_end') && trim($this->input->post('date_end'))!="")
				$this->jCfg['search']['date_end'] = $this->input->post('date_end');

			if($this->input->post('colum') && trim($this->input->post('colum'))!="")
				$this->jCfg['search']['colum'] = $this->input->post('colum');
			else
				$this->jCfg['search']['colum'] = "";	

			if($this->input->post('keyword') && trim($this->input->post('keyword'))!="")
				$this->jCfg['search']['keyword'] = $this->input->post('keyword');
			else
				$this->jCfg['search']['keyword'] = "";

			$this->_releaseSession();
		}

		if($this->input->post('btn_reset')){
			$this->_reset();
		}

		$this->per_page = 20;

		$par_filter = array(
				"offset"	=> $this->uri->segment($this->uri_segment),
				"limit"		=> $this->per_page,
				"param"		=> $this->cat_search
			);
		$this->data_table = $this->M->data_user($par_filter);
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	

	function add(){	
		$this->breadcrumb[] = array(
				"title"		=> "Add"
			);		

		$group = $this->db->get_where("app_acl_group",array(
					"ag_group_status"	=>	"1",
					"is_trash <>" => "1"	
				))->result();

		$this->_v($this->folder_view.$this->prefix_view."_form",array(
			'group'		=> $group
		));
	}

	function edit(){

		$this->breadcrumb[] = array(
				"title"		=> "Edit"
			);
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));

		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
					'user_id'	=> $id
				));
			$role = array();
			$role_tmp = $this->db->get_where("app_user_group",array(
					"ug_user_id"	=> $id
				))->result();	

			foreach ((array)$role_tmp as $k => $v) {
					$role[] = $v->ug_group_id;
			}	


			$group = $this->db->get_where("app_acl_group",array(
					"ag_group_status"	=>	"1",
					"is_trash <>" => "1"	
				))->result();
			$this->_v($this->folder_view.$this->prefix_view."_form",array(
				'group'		=> $group,
				'role'		=> $role
			));
		}else{
			redirect($this->own_link);
		}
	}
	
	function delete(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id) != ''){
			$o = $this->DATA->_delete(
				array("user_id"	=> idClean($id))
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data user succes')."&type_msg=success");
	}

	function save(){

		$data = array(
			'user_fullname'			=> $this->input->post('user_fullname'),
			'user_name'				=> $this->input->post('user_name'),
			'user_email'			=> $this->input->post('user_email'),
			'user_telp'				=> $this->input->post('user_telp'),
			'is_show_all'			=> isset($_POST['is_show_all'])?1:0,
			'user_status'			=> $this->input->post('user_status')
		);		
		

		if( isset($_POST['user_password']) && trim($_POST['user_password']) != ''){
			$data['user_password'] = md5(dbClean($_POST['user_password']));
		}
		
		$a = $this->_save_master( 
			$data,
			array(
				'user_id' => dbClean($_POST['user_id'])
			),
			dbClean($_POST['user_id'])			
		);

		$id = $a['id'];

		if(isset($_POST['user_group']) && count($_POST['user_group']) > 0){
			$this->db->delete("app_user_group",array(
					"ug_user_id"	=> $id
				));
			foreach ((array)$_POST['user_group'] as $k => $v) {
				$this->db->insert("app_user_group",array(
						"ug_user_id"	=> $id,
						"ug_group_id"	=> $v,
						"ug_status"		=> 1
					));
			}
		}

		$this->_uploaded(
		array(
			'id'		=> $id ,
			'input'		=> 'user_photo',
			'param'		=> array(
							'field' => 'user_photo', 
							'par'	=> array('user_id' => $id)
						)
		));
	
		redirect($this->own_link."?msg=".urldecode('Save data user succes')."&type_msg=success");
	}

}