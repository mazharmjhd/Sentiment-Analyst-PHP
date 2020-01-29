<?php
//report....
function report_member_daftar($par=array()){
	$CI = getCI();
	if( isset($par['start']) && isset($par['end']) ){
		$CI->db->where('( member_reg_date >= "'.$par['start'].' 00:00:00" AND member_reg_date <= "'.$par['end'].' 23:59:59")');
	}
	if( isset($par['fb']) ){
		$CI->db->where("member_sm_uid !=","");
	}
	if( isset($par['google']) ){
		$CI->db->where("member_sm2_uid !=","");
	}
	return $CI->db->get("web_member")->num_rows();
}

function report_team_daftar($par=array()){
	$CI = getCI();
	if( isset($par['start']) && isset($par['end']) ){
		$CI->db->where('( time_add >= "'.$par['start'].' 00:00:00" AND time_add <= "'.$par['end'].' 23:59:59")');
	}
	$CI->db->group_by("team_member_id");
	return $CI->db->get("web_team_member")->num_rows();
}

function report_member_daftar_main($par=array()){
	$CI = getCI();
	$CI->db->join("web_urutan_seri","web_urutan_seri.urut_member_id = web_member.member_id");
	if( isset($par['start']) && isset($par['end']) ){
		$CI->db->where('( member_reg_date >= "'.$par['start'].' 00:00:00" AND member_reg_date <= "'.$par['end'].' 23:59:59")');
	}
	$CI->db->group_by("member_id");
	return $CI->db->get("web_member")->num_rows();
}

function report_log($par=array()){
	$CI = getCI();
	if( isset($par['start']) && isset($par['end']) ){
		$CI->db->where('( log_date >= "'.$par['start'].' 00:00:00" AND log_date <= "'.$par['end'].' 23:59:59")');
	}
	if( isset($par['uniq_session']) ){
		$CI->db->group_by("log_session_id");
	}
	return $CI->db->get("web_log")->num_rows();
}

function report_referal($par=array()){
	$CI = getCI();
	$CI->db->select("TRIM(log_ref_code) as kode,count(log_id) as jumlah");
	if( isset($par['start']) && isset($par['end']) ){
		$CI->db->where('( log_date >= "'.$par['start'].' 00:00:00" AND log_date <= "'.$par['end'].' 23:59:59")');
	}
	$CI->db->group_by("log_ref_code");
	
	return $CI->db->get("web_log")->result();
}

function report_referal_auto($par=array()){
	$CI = getCI();
	$CI->db->select("log_data_get as info,count(log_id) as jumlah");
	if( isset($par['start']) && isset($par['end']) ){
		$CI->db->where('( log_date >= "'.$par['start'].' 00:00:00" AND log_date <= "'.$par['end'].' 23:59:59")');
	}
	$CI->db->like("log_data_get","utm_source");

	$CI->db->group_by("log_data_get");
	
	return $CI->db->get("web_log")->result();
}


function get_pembalap($par=array()){
	$CI = getCI();
	if( isset($par['type']) && trim($par['type']) !="" ){
		$CI->db->where("pembalap_type",$par['type']);
	}
	if( isset($par['wajib']) && trim($par['wajib']) == true ){
		$CI->db->where("pembalap_is_wajib",1);
	}else{
		$CI->db->where("pembalap_is_wajib",0);
	}	
	$CI->db->order_by("pembalap_nama","ASC");
	return $CI->db->get_where("web_pembalap",array(
			"pembalap_status" => 1
		))->result();
}

function get_total_member(){
	$CI = getCI();
	return $CI->db->get("web_member")->num_rows();
}

function get_pembalap_all($par=array()){
	$CI = getCI();
	if( isset($par['type']) && trim($par['type']) !="" ){
		$CI->db->where("pembalap_type",$par['type']);
	}	
	$CI->db->order_by("pembalap_nama","ASC");
	return $CI->db->get_where("web_pembalap",array(
			"pembalap_status" => 1
		))->result();
}

function get_jumlah_pembalap($type=""){
	$CI = getCI();
	if( trim($type) !="" ){
		$CI->db->where("pembalap_type",$type);
	}
	return $CI->db->get_where("web_pembalap",array(
			"pembalap_status" => 1
		))->num_rows();
}

function create_bitly($url=""){
	$url_encode = urlencode($url);
    $ch = curl_init('http://api.bitly.com/v3/shorten?login=humehumaedi&apiKey=R_50b874deea9e4c799e9be824e0a7e288&longUrl='.$url_encode);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = json_decode(curl_exec($ch));
   	$return = $url; 
    if( $result->status_code == 200 ){
    	if( isset($result->data->url) ){
    		$return = $result->data->url;
    	}
    }
    return $return;
}

function get_pembalap_team($par=array()){
	$CI = getCI();

	$CI->db->select("web_team_member.team_member_id,web_team_member.team_id,web_pembalap.*");
	$CI->db->join("web_team_member","web_team_member.team_pembalap_id = web_pembalap.pembalap_id");
	if( isset($par['type']) && trim($par['type']) !="" ){
		$CI->db->where("pembalap_type",$par['type']);
	}
	if( isset($par['member_id']) && trim($par['member_id']) !="" ){
		$CI->db->where("team_member_id",$par['member_id']);
	}
	$CI->db->order_by("web_team_member.team_id","ASC");
	return $CI->db->get_where("web_pembalap",array(
			"pembalap_status" => 1
		))->result();
}

function get_pembalap_team_own($par=array()){
	$CI = getCI();

	$CI->db->select("web_urutan_seri.urut_nomor,web_pembalap.*");
	$CI->db->join("web_urutan_seri","web_urutan_seri.urut_pembalap_id = web_pembalap.pembalap_id");
	if( isset($par['type']) && trim($par['type']) !="" ){
		$CI->db->where("pembalap_type",$par['type']);
	}
	if( isset($par['member_id']) && trim($par['member_id']) !="" ){
		$CI->db->where("urut_member_id",$par['member_id']);
	}
	if( isset($par['seri']) && trim($par['seri']) !="" ){
		$CI->db->where("urut_seri",$par['seri']);
	}
	$CI->db->order_by("web_urutan_seri.urut_team_id","ASC");
	return $CI->db->get_where("web_pembalap",array(
			"pembalap_status" => 1
		))->result();
}


function cek_inputan_seri($member_id=0,$seri=0){
	$CI = getCI();
	return $CI->db->get_where("web_urutan_seri",array(
			"urut_member_id" => $member_id,
			"urut_seri"		 => $seri
		))->num_rows();
}

function data_inputan_seri($member_id=0,$seri=0){
	$CI = getCI();
	return $CI->db->get_where("web_urutan_seri",array(
			"urut_member_id" => $member_id,
			"urut_seri"		 => $seri
		))->result();
}

function get_jadwal_id($id){
    $CI = getCI();
    return $CI->db->get_where("web_jadwal",array(
    		"jadwal_seri" => $id
    	))->row();
}

function get_jadwal_motogp(){
    $CI = getCI();
    $CI->db->order_by("jadwal_seri");
    return $CI->db->get("web_jadwal")->result();
}
function get_urutan_pembalap($seri=""){
    $CI = getCI();
    $CI->db->where("pu_seri",$seri);
    return $CI->db->get("web_pembalap_seri")->result();
}

function get_poin($seri=0,$limit=100){

	$CI = getCI();
	return $CI->db->query("
		select 
			web_member.member_name,web_member.member_team,web_urutan_seri.urut_member_id,web_member.member_id,
			( 
				(
				 sum(web_urutan_seri.urut_poin) +
				 (
					select count(member_id) from web_member member2
					where 
						member2.member_ref_id = web_urutan_seri.urut_member_id
						AND member2.member_seri = web_pembalap_seri.pu_seri
						AND member2.member_seri = ".$seri."
				  ) + (
					
					SELECT CASE WHEN (
					 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut2.urut_seri = ".$seri."
						AND urut_pembalap2.pu_status_finish = 0
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_nomor = urut_pembalap2.pu_urutan
						AND urut2.urut_member_id = web_member.member_id
					) = 4 THEN 75 ELSE 0 END

				  ) - (
				  	( 
				  	 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut2.urut_seri = ".$seri."
						AND urut_pembalap2.pu_status_finish = 1
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_member_id = web_member.member_id
					) * 10
				  )
				) * (
					
					SELECT CASE WHEN (
						SELECT 
							count(bost_id) 
						FROM 
							web_member_boster_log 
						WHERE 
							web_member_boster_log.bost_seri = web_pembalap_seri.pu_seri
							AND web_member_boster_log.bost_seri = ".$seri."
							AND web_member_boster_log.bost_member_id = web_member.member_id
					) > 0 THEN 2 ELSE 1 END 
				) 
			)  as poin 
		from 
			web_pembalap_seri,web_urutan_seri,web_member
		where
		web_member.member_id = web_urutan_seri.urut_member_id 
		AND web_pembalap_seri.pu_status_finish = 0
		AND web_urutan_seri.urut_seri = web_pembalap_seri.pu_seri
		AND web_urutan_seri.urut_pembalap_id = web_pembalap_seri.pu_pembalap_id
		AND web_urutan_seri.urut_nomor = web_pembalap_seri.pu_urutan
		AND web_pembalap_seri.pu_seri = ".$seri."
		GROUP BY web_urutan_seri.urut_member_id
		ORDER BY poin DESC, web_urutan_seri.time_add ASC
		LIMIT ".$limit."
	")->result();

}

function get_poin_all($limit=100){

	$CI = getCI();
	return $CI->db->query("
		select 
			web_member.member_name,web_member.member_team,web_urutan_seri.urut_member_id,web_member.member_id,
			( 
				(
				 sum(web_urutan_seri.urut_poin) +
				 (
					select count(member_id) from web_member member2
					where 
						member2.member_ref_id = web_urutan_seri.urut_member_id
						AND member2.member_seri = web_pembalap_seri.pu_seri
				  ) + (
					
					SELECT CASE WHEN (
					 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut_pembalap2.pu_status_finish = 0
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_nomor = urut_pembalap2.pu_urutan
						AND urut2.urut_member_id = web_member.member_id
					) = 4 THEN 75 ELSE 0 END

				  ) - (
				  	( 
				  	 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut_pembalap2.pu_status_finish = 1
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_member_id = web_member.member_id
					) * 10
				  )
				) * (
					
					SELECT CASE WHEN (
						SELECT 
							count(bost_id) 
						FROM 
							web_member_boster_log 
						WHERE 
							web_member_boster_log.bost_seri = web_pembalap_seri.pu_seri
							AND web_member_boster_log.bost_member_id = web_member.member_id
					) > 0 THEN 2 ELSE 1 END 
				) 
			)  as poin 
		from 
			web_pembalap_seri,web_urutan_seri,web_member
		where
		web_member.member_id = web_urutan_seri.urut_member_id 
		AND web_pembalap_seri.pu_status_finish = 0
		AND web_urutan_seri.urut_seri = web_pembalap_seri.pu_seri
		AND web_urutan_seri.urut_pembalap_id = web_pembalap_seri.pu_pembalap_id
		AND web_urutan_seri.urut_nomor = web_pembalap_seri.pu_urutan
		GROUP BY web_urutan_seri.urut_member_id
		ORDER BY poin DESC, web_urutan_seri.time_add ASC
		LIMIT ".$limit."
	")->result();

}

function get_poin_member($seri=0,$member_id=0){

	$CI = getCI();
	$m = $CI->db->query("
		select 
			web_member.member_name,web_member.member_team,web_urutan_seri.urut_member_id,web_member.member_id,
			( 
				(
				 sum(web_urutan_seri.urut_poin) +
				 (
					select count(member_id) from web_member member2
					where 
						member2.member_ref_id = web_urutan_seri.urut_member_id
						AND member2.member_seri = web_pembalap_seri.pu_seri
						AND member2.member_seri = ".$seri."
				  ) + (
					
					SELECT CASE WHEN (
					 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut2.urut_seri = ".$seri."
						AND urut_pembalap2.pu_status_finish = 0
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_nomor = urut_pembalap2.pu_urutan
						AND urut2.urut_member_id = web_member.member_id
					) = 4 THEN 75 ELSE 0 END

				  ) - (
				  	( 
				  	 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut2.urut_seri = ".$seri."
						AND urut_pembalap2.pu_status_finish = 1
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_member_id = web_member.member_id
					) * 10
				  )
				) * (
					
					SELECT CASE WHEN (
						SELECT 
							count(bost_id) 
						FROM 
							web_member_boster_log 
						WHERE 
							web_member_boster_log.bost_seri = web_pembalap_seri.pu_seri
							AND web_member_boster_log.bost_seri = ".$seri."
							AND web_member_boster_log.bost_member_id = web_member.member_id
					) > 0 THEN 2 ELSE 1 END 
				) 
			)  as poin 
		from 
			web_pembalap_seri,web_urutan_seri,web_member
		where
		web_member.member_id = web_urutan_seri.urut_member_id 
		AND web_pembalap_seri.pu_status_finish = 0
		AND web_urutan_seri.urut_seri = web_pembalap_seri.pu_seri
		AND web_urutan_seri.urut_pembalap_id = web_pembalap_seri.pu_pembalap_id
		AND web_urutan_seri.urut_nomor = web_pembalap_seri.pu_urutan
		AND web_pembalap_seri.pu_seri = ".$seri."
		AND web_member.member_id = ".$member_id."
		GROUP BY web_urutan_seri.urut_member_id
		ORDER BY poin DESC, web_urutan_seri.time_add ASC
	")->row();

	return isset($m->poin)?$m->poin:0;

}


function get_poin_member_all_jumlah($member_id=0){
	$CI = getCI();
	$m = $CI->db->query("
		select 
			web_member.member_name,web_member.member_team,web_urutan_seri.urut_member_id,web_member.member_id,
			( 
				(
				 sum(web_urutan_seri.urut_poin) +
				 (
					select count(member_id) from web_member member2
					where 
						member2.member_ref_id = web_urutan_seri.urut_member_id
						AND member2.member_seri = web_pembalap_seri.pu_seri
				  ) + (
					
					SELECT CASE WHEN (
					 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut_pembalap2.pu_status_finish = 0
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_nomor = urut_pembalap2.pu_urutan
						AND urut2.urut_member_id = web_member.member_id
					) = 4 THEN 75 ELSE 0 END

				  ) - (
				  	( 
				  	 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut_pembalap2.pu_status_finish = 1
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_member_id = web_member.member_id
					) * 10
				  )
				) * (
					
					SELECT CASE WHEN (
						SELECT 
							count(bost_id) 
						FROM 
							web_member_boster_log 
						WHERE 
							web_member_boster_log.bost_seri = web_pembalap_seri.pu_seri
							AND web_member_boster_log.bost_member_id = web_member.member_id
					) > 0 THEN 2 ELSE 1 END 
				) 
			)  as poin 
		from 
			web_pembalap_seri,web_urutan_seri,web_member
		where
		web_member.member_id = web_urutan_seri.urut_member_id 
		AND web_pembalap_seri.pu_status_finish = 0
		AND web_urutan_seri.urut_seri = web_pembalap_seri.pu_seri
		AND web_urutan_seri.urut_pembalap_id = web_pembalap_seri.pu_pembalap_id
		AND web_urutan_seri.urut_nomor = web_pembalap_seri.pu_urutan
		AND web_member.member_id = ".$member_id."
		GROUP BY web_urutan_seri.urut_member_id
		ORDER BY poin DESC, web_urutan_seri.time_add ASC
	")->row();

	return isset($m->poin)?$m->poin:0;
}

function get_poin_all_by_member($member_id=0){

	$CI = getCI();
	return $CI->db->query("
		select 
			web_member.member_name,web_member.member_team,web_urutan_seri.urut_seri,web_member.member_id,
			( 
				(
				 sum(web_urutan_seri.urut_poin) +
				 (
					select count(member_id) from web_member member2
					where 
						member2.member_ref_id = web_urutan_seri.urut_member_id
						AND member2.member_seri = web_pembalap_seri.pu_seri
				  ) + (
					
					SELECT CASE WHEN (
					 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut_pembalap2.pu_status_finish = 0
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_nomor = urut_pembalap2.pu_urutan
						AND urut2.urut_member_id = web_member.member_id
					) = 4 THEN 75 ELSE 0 END

				  ) - (
				  	( 
				  	 select 
						count(urut_id)
					 from 
						web_urutan_seri urut2,web_pembalap_seri urut_pembalap2
					 where
						urut2.urut_seri = urut_pembalap2.pu_seri
						AND urut_pembalap2.pu_status_finish = 1
						AND urut2.urut_pembalap_id = urut_pembalap2.pu_pembalap_id
						AND urut2.urut_member_id = web_member.member_id
					) * 10
				  )
				) * (
					
					SELECT CASE WHEN (
						SELECT 
							count(bost_id) 
						FROM 
							web_member_boster_log 
						WHERE 
							web_member_boster_log.bost_seri = web_pembalap_seri.pu_seri
							AND web_member_boster_log.bost_member_id = web_member.member_id
					) > 0 THEN 2 ELSE 1 END 
				) 
			)  as poin 
		from 
			web_pembalap_seri,web_urutan_seri,web_member
		where
		web_member.member_id = web_urutan_seri.urut_member_id 
		AND web_pembalap_seri.pu_status_finish = 0
		AND web_urutan_seri.urut_seri = web_pembalap_seri.pu_seri
		AND web_urutan_seri.urut_pembalap_id = web_pembalap_seri.pu_pembalap_id
		AND web_urutan_seri.urut_nomor = web_pembalap_seri.pu_urutan
		AND web_member.member_id = ".$member_id."
		GROUP BY web_urutan_seri.urut_seri
		ORDER BY web_urutan_seri.urut_seri ASC
	")->result();


}

function get_team_balap_seri($seri=0,$member_id=0){
	$CI = getCI();
	$m = $CI->db->query("
		select 
			web_pembalap.pembalap_nama,web_urutan_seri.urut_poin,
			web_pembalap_seri.pu_status_finish,web_pembalap_seri.pu_urutan,
			web_urutan_seri.urut_nomor
		from web_pembalap, web_pembalap_seri, web_urutan_seri
		where
			web_pembalap.pembalap_id = web_pembalap_seri.pu_pembalap_id
			AND web_pembalap_seri.pu_pembalap_id = web_urutan_seri.urut_pembalap_id
			AND web_urutan_seri.urut_member_id = '".$member_id."'
			AND web_urutan_seri.urut_seri = '".$seri."'
	")->result();

	return $m;
}

function get_poin_link($seri=0,$member_id=0){

	$CI = getCI();
	$m = $CI->db->query("
		select 
			* from web_member
		where 
			member_ref_id = '".$member_id."'
			AND member_seri = '".$seri."'
		ORDER BY member_reg_date ASC
	")->result();

	return $m;

}

