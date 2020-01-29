<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Bayes extends AdminController {  
    function __construct()    
    {
        parent::__construct();    
        $this->_set_action();
        $this->_set_title( 'Cek Sentiment' );
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
                "title"     => "Sentiment Analytics"
            );
        $data = array();
        if( isset($_POST['proses']) && isset($_POST['text']) ){
            if( trim( $this->input->post('text') )!=""){
                $m = bayes(array(
                        "text" => $this->input->post('text')
                    ));

                $data['hasil'] = $m;
                $data['text'] = $this->input->post('text');
                $data['stemming'] = stemming(array(
                        "text" => $this->input->post('text')
                    ));
            }
        }
        $this->_v($this->folder_view.$this->prefix_view,$data);
    }
    
    function save(){
        redirect($this->own_link);
    }

}

