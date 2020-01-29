<?php
//new dashboard...
function get_stream($limit=30){
    $CI = getCI();
    $CI->db->order_by("id","DESC");
    $CI->db->limit($limit);
    return $CI->db->get_where("app_stream_data",array(
            "id !=" => ""
        ))->result();
}

function get_count_stream($p=array()){
    $CI = getCI();
    if( isset($p['sentiment']) && trim($p['sentiment'])!="" ){
        $CI->db->where("sentiment",$p['sentiment']);
    }
    if( isset($p['start']) && isset($p['end']) ){
        $CI->db->where("( time_add >= '".$p['start']." 01:00:00' AND time_add <= '".$p['end']." 23:59:00' )");
    }
    return $CI->db->get_where("app_stream_data",array(
            "id !=" => ""
        ))->num_rows();
}


function get_count_pie(){
    $CI = getCI();
    $CI->db->select('count(id) as jumlah, sentiment');
    $CI->db->group_by('sentiment');
    return $CI->db->get_where("app_stream_data",array(
            "sentiment !=" => "0"
        ))->result();
}

function get_count_line($p=array()){
    $CI = getCI();
    if( isset($p['sentiment']) && trim($p['sentiment'])!="" ){
        $CI->db->where("sentiment",$p['sentiment']);
    }
    if( isset($p['start']) && isset($p['end']) ){
        $CI->db->where("( time_add >= '".$p['start']." 01:00:00' AND time_add <= '".$p['end']." 23:59:00' )");
    }
    $CI->db->select('count(id) as jumlah, DATE_FORMAT(time_add,"%Y-%m-%d") as tanggal');
    $CI->db->group_by('DATE_FORMAT(time_add,"%Y-%m-%d")');
    return $CI->db->get_where("app_stream_data",array(
            "id !=" => ""
        ))->result();
}





