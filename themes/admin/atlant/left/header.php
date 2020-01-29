<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>HOME <?php echo cfg('app_name');?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo themeUrl();?>img/logo-index-small.png" type="image/x-icon" />
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
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo themeUrl();?>css/theme-night.css"/> 
        <!-- EOF CSS INCLUDE -->                                       
        <?php load_css();?>
        <style type="text/css">
        	
        	<?php 
	        $bg_default 	= themeUrl()."/img/bg-app.jpg";
	        $logo_default 	= themeUrl()."/img/logo-login.png";
            ?>
	        
            .x-navigation > li.xn-logo > a:first-child {
                background:#fff url("<?php echo $logo_default;?>") no-repeat scroll center top;
                border-bottom: 1px solid #33414e;
                background-size: 200px;
                color: #fff;
                font-size: 0;
                height: 50px;
                padding: 0; 
                text-indent: -9999px;
            }

            .x-navigation.x-navigation-minimized > li.xn-logo > a:first-child {
                background-image: url("<?php echo themeUrl();?>/img/logo-login-small.png");
                padding: 0;
                width: 50px;
                background-size: 50px;
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

    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="<?php echo site_url();?>">ATLANT</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                                <img src="<?php echo $this->jCfg['user']['image'];?>" alt="<?php echo $this->jCfg['user']['fullname'];?>" width="35" height="35"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="<?php echo $this->jCfg['user']['image'];?>" alt="<?php echo $this->jCfg['user']['fullname'];?>" width="100" height="100"/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name"><?php echo $this->jCfg['user']['fullname'];?></div>
                                <div class="profile-data-title"><?php echo $this->jCfg['user']['name'];?>/<?php echo isset($this->jCfg['user']['role'][0])?get_role_name($this->jCfg['user']['role'][0]):'None';?></div>
                            </div>
                            <!--<div class="profile-controls">
                                <a href="<?php echo site_url('meme/me/profile');?>" class="profile-control-left"><span class="fa fa-info"></span></a>
                                <a href="<?php echo site_url('meme/me/edit_profile');?>" class="profile-control-right"><span class="fa fa-edit"></span></a>
                            </div>-->
                        </div>                                                                        
                    </li>
                    <li class="xn-title">MENU <?php echo cfg('app_name');?></li>
                    <?php echo left_menu($this->jCfg['menu'],true);?>
                    
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                     <!--<li class="xn-search">
                       <form role="form">
                            <input type="text" name="search" placeholder="Search..."/>
                        </form>
                    </li>-->   
                    <!-- END SEARCH -->                    
                    <!-- POWER OFF -->

                    <li class="xn-icon-button pull-right last">
                        <a href="#"><span class="fa fa-power-off"></span></a>
                        <ul class="xn-drop-left animated zoomIn">
                            <li><a href="<?php echo site_url('admin/me/change_password');?>"><span class="fa fa-lock"></span>Ganti Password</a></li>
                            <li><a href="<?php echo site_url('auth/out');?>" class="act_confirm" data-title="Logout" data-body="Apakah anda yakin akan logout ?" data-desc="Tekan Tidak jika anda ingin melanjutkan pekerjaan anda. Tekan Ya untuk keluar." data-icon="fa-sign-out"><span class="fa fa-sign-out"></span> Sign Out</a></li>
                        </ul>                        
                    </li>
                    
                    <!-- END POWER OFF -->                    
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <?php get_breadcrumb($this->breadcrumb);?>
                <!-- END BREADCRUMB -->                       
                <div class="row" style="height:0px;" id="row-after-header">
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
                                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                  <span></span> <b class="caret"></b>
                                </div>
                            </ul>

                        <?php } ?>  
                         </div>                                                   
                        <!-- END TABS -->               
                    </div>  
                    <div style="clear:both;"></div>
                    <div style="border-bottom:0px solid #009F9A;margin:-20px 10px 10px 10px;" id="border-header"></div>           
                </div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row" style="margin:-20px 10px 10px 10px;">
                        <div class="col-md-12 panel" id="panel-content-wrap" style="border-radius:0px;padding:20px;">
