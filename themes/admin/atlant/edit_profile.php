<?php js_validate();?>
<div style="background:#F5F5F5;padding:20px;margin-bottom:40px">
  <a href="<?php echo site_url('meme/me/oauth/twitter');?>">
    <img src="<?php echo themeUrl();?>images/addtw.png" style="width:250px">
  </a>
  <a href="<?php echo site_url('meme/me/oauth/facebook');?>">
    <img src="<?php echo themeUrl();?>images/addfb.png" style="width:250px">
  </a>
</div>
<form id="form-validated" enctype="multipart/form-data" action="" class="form-horizontal" method="post"> 
        <input type="hidden" name="user_id" id="user_id" value="<?php echo isset($val->user_id)?$val->user_id:'';?>" />
        <div class="row">
          <div class="col-md-5">


             <div class="row form-group">  
              <div class="col-md-5 control-label">Nama Lengkap</div>
              <div class="col-md-7">
                <input type="text" id="user_fullname" name="user_fullname" class="validate[required] form-control" value="<?php echo isset($val->user_fullname)?$val->user_fullname:'';?>" />
              </div>
            </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">Email</div>
              <div class="col-md-7">
                <input type="text" id="user_email" name="user_email" class="validate[required,custom[email]] form-control" value="<?php echo isset($val->user_email)?$val->user_email:'';?>" />
              </div> 
            </div> 

            <div class="row form-group">  
              <div class="col-md-5 control-label">No. Telp</div>
              <div class="col-md-7">
                <input type="text" id="user_telp" name="user_telp" class="validate[required,custom[number]] form-control" value="<?php echo isset($val->user_telp)?$val->user_telp:'';?>" />
              </div>
            </div>

          </div> 

          <div class="col-md-6">

            <div class="row form-group">
              <div class="col-md-5 control-label">Photo Profile</div>
              <div class="col-md-7">
                  <input type="file" id="user_photo" class="fileinput btn-primary" name="user_photo" />
                  <?php if( isset($val->user_photo) && trim($val->user_photo)!="" ){?>
                  <br>
                  <a href="<?php echo get_image(base_url()."assets/collections/photo/".$val->user_photo);?>" title="Image Photo" class="act_modal" rel="700|400">
                    <img alt="" src="<?php echo get_image(base_url()."assets/collections/photo/".$val->user_photo);?>" style="height:25px;width:25px" class="img-polaroid">
                  </a>
                  <?php } ?>
              </div> 
            </div>

            <div class="row form-group">
              <div class="col-md-5 control-label">Share on Social Media</div>
              <div class="col-md-7">
                <label class="check"><input type="radio" <?php echo isset($val)&&$val->is_share==1?'checked="checked"':'';?> name="is_share" class="icheckbox validate[required]" value="1"/> Ya</label>&nbsp &nbsp &nbsp
                 <label class="check"><input type="radio" <?php echo isset($val)&&$val->is_share==0?'checked="checked"':'';?> name="is_share" class="icheckbox validate[required]" value="0" /> Tidak</label>
              </div> 
            </div>

          </div>       
        </div>
        <br />
        
        <div class="panel-footer">
          <div class="pull-left">
            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button>
          </div>
          <div class="pull-right">
            <button type="submit" name="update" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
          </div>
        </div>

</form>