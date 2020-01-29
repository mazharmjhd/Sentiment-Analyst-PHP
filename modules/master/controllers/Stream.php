<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Stream extends AdminController {  
    function __construct()    
    {
        parent::__construct();    
        $this->_set_action();
        $this->_set_title( 'Data Stream' );
        $this->DATA->table="app_stream_data";
        $this->folder_view = "master/";
        $this->prefix_view = 'stream';
        $this->breadcrumb[] = array(
                "title"     => "Stream",
                "url"       => $this->own_link
            );

        $this->cat_search = array(
            ''                => 'All',
            'user_name'   => 'Username',
            'text'        => 'Text'
        ); 

        if(!isset($this->jCfg['search']) || !isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
            $this->_reset();
            redirect($this->own_link);
        }

        //load js..
        $this->js_plugins = array(
            'plugins/bootstrap/bootstrap-datepicker.js',
            'plugins/bootstrap/bootstrap-file-input.js',
            'plugins/bootstrap/bootstrap-select.js'
        );
        
        $this->load->model("mdl_master","M");
    }

    function _reset(){
        $this->sCfg['search'] = array(
                                'class'     => $this->_getClass(),
                                'date_start'=> '',
                                'date_end'  => '',
                                'status'    => '',
                                'sla'       => 'all',
                                'per_page'  => 20,
                                'order_by'  => 'id',
                                'order_dir' => 'DESC',
                                'colum'     => '',
                                'is_done'   => FALSE,
                                'keyword'   => ''
                            );
        $this->_releaseSession();
    }

    function index(){
        $this->breadcrumb[] = array(
                "title"     => "List"
            );
        $data = array();

        if($this->input->post('btn_search')){
            if($this->input->post('date_start') && trim($this->input->post('date_start'))!="")
                $this->sCfg['search']['date_start'] = $this->jCfg['search']['date_start'] = $this->input->post('date_start');

            if($this->input->post('date_end') && trim($this->input->post('date_end'))!="")
                $this->sCfg['search']['date_end'] = $this->jCfg['search']['date_end'] = $this->input->post('date_end');

            if($this->input->post('colum') && trim($this->input->post('colum'))!="")
                $this->sCfg['search']['colum'] = $this->jCfg['search']['colum'] = $this->input->post('colum');
            else
                $this->sCfg['search']['colum'] = $this->jCfg['search']['colum'] = "";   

            if($this->input->post('keyword') && trim($this->input->post('keyword'))!="")
                $this->sCfg['search']['keyword']  = $this->jCfg['search']['keyword'] = $this->input->post('keyword');
            else
                $this->sCfg['search']['keyword']  = $this->jCfg['search']['keyword'] = "";

            $this->_releaseSession();
        }

        if($this->input->post('btn_reset')){
            $this->_reset();
        }

        $this->per_page = $this->jCfg['search']['per_page'];
        $par_filter = array(
                "offset"    => (int)$this->uri->segment($this->uri_segment),
                "limit"     => $this->per_page,
                "param"     => $this->cat_search
            );

        $this->data_table = $this->M->stream($par_filter);
        $data = $this->_data(array(
                "base_url"  => $this->own_link.'/index'
            ));
        $this->_v($this->folder_view.$this->prefix_view,$data);
    }
    

}

