<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Stimming extends AdminController {  
    function __construct()    
    {
        parent::__construct();    
        $this->_set_action();
        $this->_set_title( 'Data Stimming' );
        $this->DATA->table="app_stream_data";
        $this->folder_view = "master/";
        $this->prefix_view = strtolower($this->_getClass());
        $this->breadcrumb[] = array(
                "title"     => "Stimming",
                "url"       => $this->own_link
            );

        //load js..
        $this->js_plugins = array(
            'plugins/bootstrap/bootstrap-file-input.js',
            'plugins/bootstrap/bootstrap-select.js'
        );

        $this->load->helper('magic');
    }


    function index(){
        $this->breadcrumb[] = array(
                "title"     => "Stimming Test"
            );
        $data = array();

        if( isset($_POST['proses']) && isset($_POST['text']) ){
            if( trim( $this->input->post('text') )!=""){
                $m = stemming(array(
                        "text" => $this->input->post('text')
                    ));

                $data['hasil'] = $m;
                $data['original'] = $this->input->post('text');
            }
        }

        $this->_v($this->folder_view.$this->prefix_view,$data);
    }
    
    function save(){
        redirect($this->own_link);
    }

}

