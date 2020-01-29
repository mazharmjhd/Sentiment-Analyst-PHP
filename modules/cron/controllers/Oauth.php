<?php
include_once(APPPATH."libraries/FrontController.php");
class Oauth extends FrontController {
    function __construct()  
    {
        parent::__construct();     
    }
    function index(){ die('Access Denied.');}
    function twitter(){ 
        require_once(APPPATH.'/libraries/twitteroauth/twitteroauth.php');
        
        if(isset($_SESSION['access_token'])){
            unset($_SESSION['access_token']);
        }

        $call_back = site_url('cron/oauth/callback');
        $connection = new TwitterOAuth(cfg('tw_app_id'), cfg('tw_app_secret'));
        $request_token = $connection->getRequestToken($call_back);
        
        /* Save temporary credentials to session. */
        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
        
        $token = $request_token['oauth_token'];
        
        if($connection->http_code==200){
            $url = $connection->getAuthorizeURL($token);
            redirect($url);
        }else{
            redirect(site_url('cron/oauth/twitter'));
        }
        
    }
    
    function callback(){
        require_once(APPPATH.'/libraries/twitteroauth/twitteroauth.php');
        $oauth_token    = isset($_GET['oauth_token'])?$_GET['oauth_token']:'';
        $oauth_verifier = isset($_GET['oauth_verifier'])?$_GET['oauth_verifier']:'';
        
        if(!isset($_SESSION['oauth_token'])){
            redirect(site_url('cron/oauth/twitter'));
        }
        $connection = new TwitterOAuth(
                                       cfg('tw_app_id'), 
                                       cfg('tw_app_secret'),
                                       $_SESSION['oauth_token'], 
                                       $_SESSION['oauth_token_secret']
                                     );
        $access_token = $connection->getAccessToken($oauth_verifier);
        
        debugCode($access_token);        
        
    }
    
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */