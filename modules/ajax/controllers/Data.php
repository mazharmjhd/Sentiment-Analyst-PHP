<?php
include_once(APPPATH."libraries/FrontController.php");
class Data extends FrontController {

	function __construct()  
	{
		parent::__construct(); 		
	}
	function index() {}
	function get_kota(){
		
		$prov = $this->input->post('prov');
		$kota = $this->input->post('kota');

		$this->db->order_by("kab_nama");
		$m = $this->db->get_where("app_kabupaten",array(
				"kab_propinsi_id"	=> $prov,
				"kab_status"		=> 0
			))->result();

		$html = "<option value=''> - PILIH - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->kab_id==$kota?'selected="selected"':'';
			$html .= "<option value='".$v->kab_id."' $s >".$v->kab_nama."</option>";
		}

		die($html);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */