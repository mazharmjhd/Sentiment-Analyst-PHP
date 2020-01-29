<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title><?php echo cfg('app_name');?> - CMS</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->
        <script type="text/javascript">
            var BASE_URL = '<?php echo base_url();?>';  
            var THEME_URL = '<?php echo themeUrl();?>';  
            var CURRENT_URL = '<?php echo current_url();?>';
            var CURRENT_MODULE = '<?php echo $this->own_link;?>';
            var AJAX_URL       = '<?php echo site_url("ajax/data");?>';
            var MEME = {};
        </script>

        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo themeUrl();?>css/theme-light.css"/>
        <?php load_css();?>

        <style type="text/css">
        <?php 
        $bg_default 	= themeUrl()."/img/bg-app.jpg";
        $logo_default 	= themeUrl()."/img/logo-login.png";
        if( trim($this->jCfg['user']['template_brand']['bg'])!="" ){
        	$bg_default = get_new_image(array(
        		'url'	=> base_url()."assets/collections/brand/".$this->jCfg['user']['template_brand']['bg'],
        		"folder"  => "brand",
				"site_id" => 0
        	));
        } 
        
        if( trim($this->jCfg['user']['template_brand']['bg'])!="" ){
        	$logo_default = get_new_image(array(
        		'url'	=> base_url()."assets/collections/brand/".$this->jCfg['user']['template_brand']['logo'],
        		"folder"  => "brand",
				"site_id" => 0
        	));
        } ?>
        /*.page-content-header,.page-container .page-content{
            background:#fff url('<?php echo $bg_default;?>') center top;
            background-size: cover;
        }*/
        .table > thead > tr > th a{
            color: #fff;
            text-decoration: underline;
        }
        .heading-form{
                  font-size: 18px;
                  font-weight: normal;
                  border-bottom: 1px dotted #33414E;
                  border-left:4px solid #33414E;
                  padding-left: 10px;
                  padding-bottom: 4px;
            }
        </style>  

        <!-- EOF CSS INCLUDE -->                                     
    </head>
    <body>
        <?php get_info_message();?>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top page-navigation-top-custom">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START PAGE CONTENT HEADER -->
                <?php if($this->jCfg['theme_setting']['header']==true){?>
                <div class="page-content-header">
                    <div class="pull-left">
                        <a href="<?php echo site_url();?>">
                            <img src="<?php echo $logo_default;?>" height="40" />
                        </a>
                    </div>
                    <div class="pull-right">                        
                        <div class="socials">
                            <!--<a href="#"><span class="fa fa-facebook-square"></span></a>
                            <a href="#"><span class="fa fa-twitter-square"></span></a>
                            <a href="#"><span class="fa fa-pinterest-square"></span></a>
                            <a href="#"><span class="fa fa-linkedin-square"></span></a>
                            <a href="#"><span class="fa fa-dribbble"></span></a> 
                            -->
                            <?php echo myDate(date("Y-m-d H:i:s"),"d M Y H:i");?>                                                     
                        </div>
                        <div class="contacts">
                        <a style="color:#111;"><span class="fa fa-user"></span> <?php echo $this->jCfg['user']['fullname'];?>, <?php echo $this->jCfg['user']['name'];?></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <!-- END PAGE CONTENT HEADER -->
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal">
                    <?php if($this->jCfg['theme_setting']['header']==true){?>
                    <li class="xn-navigation-control">
                        <a href="<?php echo site_url('admin/me');?>" class="x-navigation-control"></a>
                    </li>
                    <?php }else{ ?>
                    <li class="xn-logo">
                        <img src="<?php echo themeUrl();?>img/logo-login.png" height="40" />
                        <a href="<?php echo site_url('admin/me');?>" class="x-navigation-control"></a>
                    </li>
                    <?php } ?>
                    <?php top_menu($this->jCfg['menu']);?>
                    <!-- POWER OFF -->
                    <li class="xn-icon-button pull-right last">
                        <a href="#"><span class="fa fa-power-off"></span></a>
                        <ul class="xn-drop-left animated zoomIn">
                            <li><a href="<?php echo site_url('admin/me/change_password');?>"><span class="fa fa-lock"></span>Ganti Password</a></li>
                            <li><a href="<?php echo site_url('auth/out');?>" class="act_confirm" data-title="Logout" data-body="Apakah anda yakin akan logout ?" data-desc="Tekan Tidak jika anda ingin melanjutkan pekerjaan anda. Tekan Ya untuk keluar." data-icon="fa-sign-out"><span class="fa fa-sign-out"></span> Sign Out</a></li>
                        </ul>                        
                    </li>
                    

                    <?php if( $this->jCfg['user']['is_all'] == 1){?>
                    <li class="xn-icon-button pull-right last">
                        <a href="<?php echo site_url('admin/me/set_theme')."?next=".current_url();?>"><span class="fa fa-cog"></span></a>                      
                    </li>
                    <?php }else{ ?>
                    <li class="xn-icon-button pull-right last">
                        <a href="#"><span class="fa fa-cog"></span> </a>
                        <ul class="xn-drop-left animated zoomIn">
                            <li><a href="<?php echo site_url('admin/me/set_theme')."?next=".current_url();?>"><i class="fa fa-star-half-o"></i>Change Admin Layout</a></li>
                            <li><a href="<?php echo site_url('admin/me/template');?>"><i class="fa fa-suitcase"></i>Manage Brand</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                    

                    <!--<li class="xn-icon-button pull-right last">
                        <a href="#"><span class="fa fa-question-circle"></span></a>
                        <ul class="xn-drop-left animated zoomIn">
                            <li><a href="<?php echo site_url('meme/me/manual/001');?>"><span class="fa fa-file"></span>Introduction</a></li>
                            <li><a href="<?php echo site_url('meme/me/manual/002');?>"><span class="fa fa-file"></span>Dashboard</a></li>
                            <li><a href="<?php echo site_url('meme/me/manual/003');?>"><span class="fa fa-file"></span>Setting</a></li>
                            <li><a href="<?php echo site_url('meme/me/manual/004');?>"><span class="fa fa-file"></span>Master</a></li>
                            <li><a href="<?php echo site_url('meme/me/manual/005');?>"><span class="fa fa-file"></span>Project</a></li>
                            <li><a href="<?php echo site_url('meme/me/manual/006');?>"><span class="fa fa-file"></span>Expediting</a></li>
                            <li><a href="<?php echo site_url('meme/me/manual/007');?>"><span class="fa fa-file"></span>Traffic</a></li>
                            <li><a href="<?php echo site_url('meme/me/manual/008');?>"><span class="fa fa-file"></span>Report</a></li>
                        </ul>                        
                    </li>-->
                    
               
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- START BREADCRUMB -->
                <?php get_breadcrumb($this->breadcrumb);?>
                <!-- END BREADCRUMB -->                
                <div class="row" id="row-after-header">
                    <div class="col-md-6">
                        <div class="page-title">                    
                            <h2><a href="<?php echo $this->own_link;?>"><span class="fa fa-arrow-circle-o-left"></span></a> <?php echo isset($title)?$title:'';?></h2>
                        </div>   
                    </div>   
                    <div class="col-md-6">
                        <!-- START TABS -->                                
                        <div class="panel panel-default tabs" style="border-top-width:0px;">   
                        <?php if($this->is_dashboard==FALSE){?>
                                                 
                            
                            <ul class="nav nav-tabs pull-right" role="tablist">
                                <?php isset($links)?getLinksWebArch($links):'';?> 
                            </ul>                            
                            
                              
                        <?php }else{ ?>
                            <style type="text/css">
                            .daterangepicker .daterangepicker_input i{
                                left: 10px;
                                top: -23px;
                            }
                            .daterangepicker .daterangepicker_input input.input-mini{
                                padding-left: 30px;
                            }
                            </style>
                            <ul class="nav nav-tabs pull-right" role="tablist" style="margin-top:-30px;">
                                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                </div>
                            </ul>

                        <?php } ?>  
                         </div>                                                   
                        <!-- END TABS -->               
                    </div>  
                    <div style="clear:both;"></div>
                    <div style="border-bottom:1px solid #009F9A;margin:-20px 10px 10px 10px;" id="border-header"></div>           
                </div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row" style="margin:-20px 10px 10px 10px;">
                        <div class="col-md-12 panel" id="panel-content-wrap" style="border-radius:0px;padding:20px;">


