<?php
/* database config */ 
$cfg['db']['hostname'] = "localhost";
$cfg['db']['username'] = "root";
$cfg['db']['password'] = "";
$cfg['db']['database'] = "kkp"; 
$cfg['db']['dbdriver'] = "mysql";
/* module location HMVC */
$config['folder_modules']    = 'modules';
$config['modules_locations'] = array(
    getcwd().'/'.$config['folder_modules'].'/' => '../../'.$config['folder_modules'].'/',
);

$config['template_admin']   = 'atlant';

$config['today']            = date("Y-m-d");
$config['mycript']          = true; 
$config['encryption_key']   = 'r3m4j4Id4m4n'; 

$config['activeLog']        = false;
$config['booster']          = 1;

$config['base_url']         = "http://".$_SERVER['SERVER_NAME']."/kkp";

$config['member_count_booster'] = 1;

$config['tw_app_id'] = 'lk9HH9bnBwpQYiywrpFF1bsvu';
$config['tw_app_secret'] = '55PRLtMhhXWaqDMhYV6DdhhLEAlnNZQdfH42DPk9Ait0Fzc7Fm';

$config['bulan'] = array(
        "01" => "Januari",
        "02" => "Februari",
        "03" => "Maret",
        "04" => "April",
        "05" => "Mei",
        "06" => "Juni",
        "07" => "Juli",
        "08" => "Agustus",
        "09" => "September",
        "10" => "Oktober",
        "11" => "November",
        "12" => "Desember"
    );
// upload path...
$config['upload_path']              = getcwd()."/assets/collections/";
