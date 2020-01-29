<?php
function data_option($sec=""){
    $CI  = getCI();
    $CI->db->order_by('brand_name','ASC');
    $CI->db->where('brand_status',1);
    if( $CI->jCfg['user']['is_all'] != 1 ){
        $CI->db->where("brand_id",$CI->jCfg['user']['section']);
    }
    if( trim($sec)!="" ){
        $CI->db->where("brand_id",$sec);
    }
    return $CI->db->get("web_brand")->result();
}
function cek_edit_pembalap($member_id="",$seri=""){
    $CI  = getCI();
    $m = $CI->db->get_where("web_member_edit_log",array(
            "edit_member_id" => $member_id,
            "edit_seri"      => $seri
        ))->num_rows();

    if( $m == 0 ){
        return true;
    }else{
        return false;
    }

}

function cek_booster_seri($member_id="",$seri=""){
    $CI  = getCI();
    return $CI->db->get_where("web_member_boster_log",array(
            "bost_member_id" => $member_id,
            "bost_seri"      => $seri
        ))->row();
}

function cek_booster($member_id=""){
    $CI  = getCI();
    $m = $CI->db->get_where("web_member_boster_log",array(
            "bost_member_id" => $member_id
        ))->num_rows();

    if( $m == 0 ){
        return true;
    }else{
        return false;
    }
}

function add_bracket_array($val=""){
    $result = '';
    if( is_array($val) && count($val) ){
        $itm = array();
        foreach ((array)$val as $v) {
            $itm[] = "{".$v."}";
        }
        $result = implode(",", $itm);
    }
    return $result;
}
function _expl($val="",$sl=","){
    return explode($sl, $val);
}

function _impl($val=array(),$sl=","){
    if( count($val) > 0 ){
        return implode($sl, $val);
    }else{
        return '';     
    }
}
function add_bracket($val=""){
    $result = '';
    if( trim($val)!="" ){
        $t = explode(",", $val);
        $itm = array();
        foreach ((array)$t as $v) {
            $itm[] = "{".$v."}";
        }
        $result = implode(",", $itm);
    }
    return $result;
}

function remove_bracket($val=""){
    $valx = str_replace("{", "", $val);
    $valx = str_replace("}", "", $valx);
    return $valx;
}

function option_section($dom=""){
    $q= data_option();
    $callback = "";
    if( count($q) > 0 ){
        foreach ($q as $key => $value) {
            $selected = $value->brand_id==$dom?"selected='selected'":"";
            $callback .= "<option value='".$value->brand_id."' $selected >".$value->brand_name."</option>";
        }
    }
    return $callback;       
}

function get_province(){
    $CI = getCI();
    $CI->db->order_by('propinsi_nama','ASC');
    //$CI->db->where('propinsi_status',1);
    return $CI->db->get("app_propinsi")->result();
}

function get_brand(){
    $CI = getCI();
    $CI->db->order_by('brand_name','ASC');
    $CI->db->where('brand_status',1);
    return $CI->db->get("web_brand")->result();
}

function get_url_connect_radius($p=array()){
	$url = site_url('connect')."?rad=yes&serial=".$p['serial']."&client_mac=".$p['mac']."&client_ip=".$p['ip']."&userurl=".site_url($p['url_success'])."&login_url=".site_url($p['login_url']);
	return $url;
}

function db_radius(){
	$CI = getCI();
	return $CI->load->database('radius',TRUE);
}
function insert_radius($par=array()){
	$CI = getCI();
	$DB = $CI->load->database('radius',TRUE);
	/*$m  = $DB->insert("radcheck",array(
		"username" => $par['username'],
		"attribute" => isset($par['attr'])?$par['attr']:'Cleartext-Password',
		"op" => isset($par['op'])?$par['op']:':=',
		"value" => isset($par['value'])?$par['value']:':='
	));*/
	$m = 0;
	
	if($m){
		return $DB->insert_id();
	}else{
		return 0;
	}
}
function generate_ads($par=array()){
    $par['is_own'] = 1;
    $ads1 = generate_ads_data($par);
    $par['is_own'] = 0;
    $ads2 = generate_ads_data($par);

    $data = array_merge($ads1,$ads2);
    $idx = rand(0,count($data)-1);

    return isset($data[$idx])?$data[$idx]:array();
}
function generate_ads_data($par=array()){
    $CI = getCI();
    $status_own = $par['is_own'];

    $member = $CI->db->get_where("web_member",array(
            "member_id" => $par['member']['id']
        ))->row();
    $hotspot = $CI->db->get_where("web_hotspot",array(
            "hotspot_id" => $par['radius']['serial']
        ))->row();

    //user agent..
    $CI->load->library('user_agent');
    $agent_string = $CI->agent->agent_string();
    $platform = $CI->agent->platform();
    $brand_id = $hotspot->hotspot_brand;
    $os = '';
    if ($CI->agent->is_mobile()){
        if($CI->agent->is_mobile('iphone')){
            $os = 'ios';
        }else{
            $os = 'android';
        }
    }else{
        if($platform == 'Windows'){
             $os = 'windows';
        }
        if($platform == 'Mac OS X'){
             $os = 'macos';
        }
    }

    // ads no target..
    $ads_data = array();
    if( $status_own == 1 ){
        $ads_no_target = $CI->db->query("
                SELECT * FROM web_campaign 
                WHERE 
                    camp_start_date <= '".date("Y-m-d")."' 
                    AND camp_end_date >= '".date("Y-m-d")."'
                    AND camp_status = 1
                    AND camp_is_own = 1
                    AND camp_brand = '".$brand_id."'
                    AND camp_target_location = ''
                    AND camp_target_os = '' 
                    AND camp_target_gender = '{L},{P}'
                    AND camp_is_target_age = 0
                ORDER BY rand()
                LIMIT 1
            ")->row();
    }else{
        $ads_no_target = $CI->db->query("
                SELECT web_campaign.* FROM web_campaign,web_brand 
                WHERE 
                    web_campaign.camp_brand = web_brand.brand_id
                    AND camp_start_date <= '".date("Y-m-d")."' 
                    AND camp_end_date >= '".date("Y-m-d")."'
                    AND camp_status = 1
                    AND camp_is_own = 0
                    AND brand_saldo > ".cfg('price_per_view')."
                    AND camp_target_location = ''
                    AND camp_target_os = '' 
                    AND camp_target_gender = '{L},{P}'
                    AND camp_is_target_age = 0
                ORDER BY rand()
                LIMIT 1
            ")->row();
    }
    if( isset($ads_no_target->camp_id) ){
        $ads_data[$ads_no_target->camp_id] = $ads_no_target;
    }

    $where_by_profile = "";
    if( trim($member->member_gender)!="" && trim($member->member_gender)!=0 ){
        $where_by_profile .= " AND camp_target_gender LIKE '%{".$member->member_gender."}%' ";
    }
    if( trim($hotspot->hotspot_propinsi)!="" && trim($hotspot->hotspot_propinsi)!=0 ){
        $where_by_profile .= " AND camp_target_location LIKE '%{".$hotspot->hotspot_propinsi."}%' ";
    }
    if( trim($member->member_tgl_lahir)!="" && trim($member->member_tgl_lahir)!=0 && trim($member->member_tgl_lahir)!='0000-00-00' ){
        $umur = hitung_umur($member->member_tgl_lahir);
        $where_by_profile .= " AND camp_by_age LIKE '%{".$umur."}%' ";
    }

    if( $status_own == 1 ){
        $ads_by_profile = $CI->db->query("
                SELECT * FROM web_campaign 
                WHERE 
                    camp_start_date <= '".date("Y-m-d")."' 
                    AND camp_end_date >= '".date("Y-m-d")."'
                    AND camp_status = 1
                    AND camp_brand = '".$brand_id."'
                    AND camp_is_own = 1
                    AND ( 
                            camp_target_os LIKE '%{".$os."}%' 
                            ".$where_by_profile."
                        )
                ORDER BY rand()
                LIMIT 1
            ")->row();
    }else{
        $ads_by_profile = $CI->db->query("
                SELECT web_campaign.* FROM web_campaign,web_brand 
                WHERE 
                    web_campaign.camp_brand = web_brand.brand_id
                    AND camp_start_date <= '".date("Y-m-d")."' 
                    AND camp_end_date >= '".date("Y-m-d")."'
                    AND camp_status = 1
                    AND camp_is_own = 0
                    AND brand_saldo > ".cfg('price_per_view')."
                    AND ( 
                            camp_target_os LIKE '%{".$os."}%' 
                            ".$where_by_profile."
                        )
                ORDER BY rand()
                LIMIT 1
            ")->row();
    }
    if( isset($ads_by_profile->camp_id) ){
        $ads_data[$ads_by_profile->camp_id] = $ads_by_profile;
    }

    $where_or_profile = "";
    
    if( trim($member->member_gender)!="" && trim($member->member_gender)!=0 ){
        $where_or_profile .= " OR camp_target_gender LIKE '%{".$member->member_gender."}%' ";
    }
    
    if( trim($hotspot->hotspot_propinsi)!="" && trim($hotspot->hotspot_propinsi)!=0 ){
        $where_or_profile .= " OR camp_target_location LIKE '%{".$hotspot->hotspot_propinsi."}%' ";
    }

    if( trim($member->member_tgl_lahir)!="" && trim($member->member_tgl_lahir)!=0 && trim($member->member_tgl_lahir)!='0000-00-00' ){
        $umur = hitung_umur($member->member_tgl_lahir);
        $where_or_profile .= " OR camp_by_age LIKE '%{".$umur."}%' ";
    }

    if( $status_own == 1 ){
        $ads_or_profile = $CI->db->query("
                SELECT * FROM web_campaign 
                WHERE 
                    camp_start_date <= '".date("Y-m-d")."' 
                    AND camp_end_date >= '".date("Y-m-d")."'
                    AND camp_status = 1
                    AND camp_brand = '".$brand_id."'
                    AND camp_is_own = 1
                    AND ( 
                            camp_target_os LIKE '%{".$os."}%' 
                            ".$where_or_profile."
                        )
                ORDER BY rand()
                LIMIT 1
            ")->row();
    }else{
        $ads_or_profile = $CI->db->query("
                SELECT web_campaign.* FROM web_campaign,web_brand 
                WHERE 
                    web_campaign.camp_brand = web_brand.brand_id
                    AND camp_start_date <= '".date("Y-m-d")."' 
                    AND camp_end_date >= '".date("Y-m-d")."'
                    AND camp_status = 1
                    AND camp_is_own = 0
                    AND brand_saldo > ".cfg('price_per_view')."
                    AND ( 
                            camp_target_os LIKE '%{".$os."}%' 
                            ".$where_or_profile."
                        )
                ORDER BY rand()
                LIMIT 1
            ")->row();
    }
    if( isset($ads_or_profile->camp_id) ){
        $ads_data[$ads_or_profile->camp_id] = $ads_or_profile;
    }

    return $ads_data;
}

