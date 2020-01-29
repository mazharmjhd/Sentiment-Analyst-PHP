<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="" class="form-horizontal" method="post"> 

        <input type="hidden" name="brand_id" id="brand_id" value="<?php echo isset($val->brand_id)?$val->brand_id:'';?>" />

        <div class="row">
          <div class="col-md-6">
           <h3 class="heading-form">Info Brand</h3>
            <div class="row form-group">  
              <div class="col-md-3 control-label">Initial Brand</div>
              <div class="col-md-7">
                <input type="text" id="brand_name" name="brand_name" class="validate[required] form-control" value="<?php echo isset($val->brand_name)?$val->brand_name:'';?>" />
              </div>
            </div>

             <div class="row form-group">  
              <div class="col-md-3 control-label">Nama Brand</div>
              <div class="col-md-7">
                <input type="text" id="brand_fullname" name="brand_fullname" class="validate[required] form-control" value="<?php echo isset($val->brand_fullname)?$val->brand_fullname:'';?>" />
              </div>
            </div>

             <div class="row form-group">  
              <div class="col-md-3 control-label">Kontak</div>
              <div class="col-md-7">
                <input type="text" id="brand_cp_name" name="brand_cp_name" class="validate[required] form-control" value="<?php echo isset($val->brand_cp_name)?$val->brand_cp_name:'';?>" />
              </div>
            </div>
            <div class="row form-group">  
              <div class="col-md-3 control-label"></div>
              <div class="col-md-7">
                <input type="text" id="brand_cp_email" name="brand_cp_email" class="validate[required] form-control" value="<?php echo isset($val->brand_cp_email)?$val->brand_cp_email:'';?>" />
              </div>
            </div>

             <div class="row form-group">  
              <div class="col-md-3 control-label">Deskripsi Brand</div>
              <div class="col-md-7">
                <textarea id="brand_desc" name="brand_desc" class="form-control"><?php echo isset($val->brand_desc)?$val->brand_desc:'';?></textarea>
              </div>
            </div>

          </div> 
          <div class="col-md-6">
      <h3 class="heading-form">Setting Landing Page</h3>
            <div class="row form-group">  
              <div class="col-md-3 control-label">Logo</div>
              <div class="col-md-4">
                
                <input type="file" id="brand_logo" class="fileinput btn-primary" name="brand_logo" />
                             
                <?php if( isset($val->brand_logo) && trim($val->brand_logo)!="" ){
                    $image_thumb = get_new_image(array(
                      "url"     => cfg('upload_path_brand')."/".$val->brand_logo,
                      "folder"  => "brand",
                      "width"   => 40,
                      "height"  => 40,
                      "site_id" => 0
                    ),true);
                    
                    $image_big = get_new_image(array(
                      "url"     => cfg('upload_path_brand')."/".$val->brand_logo,
                      "folder"  => "brand",
                      "site_id" => 0
                    ),true);
                    
                  ?>
                    <a href="<?php echo $image_big;?>" title="Image Photo" class="act_modal" rel="700|400">
                      <img alt="" src="<?php echo $image_thumb;?>" style="height:25px;width:25px" class="img-polaroid">
                    </a>
                  <?php } ?>
                  <span class="help-block">Max 500kb</span>
                  
              </div>
              
              <div class="col-md-3">
              <label class="check"><input name="brand_logo_show" type="checkbox" id="brand_logo_show" <?php echo (isset($val->brand_bg_show)&& $val->brand_logo_show=="1")?'checked="checked"':'';?> class="icheckbox" /> Show Logo</label>
              </div>
              
            </div>
            
            <div class="row form-group">  
              <div class="col-md-3 control-label">Background</div>
              <div class="col-md-4">
                
                <input type="file" id="brand_bg" class="fileinput btn-primary" name="brand_bg" />
                             
                <?php if( isset($val->brand_bg) && trim($val->brand_bg)!="" ){
                    $image_thumb = get_new_image(array(
                      "url"     => cfg('upload_path_brand')."/".$val->brand_bg,
                      "folder"  => "brand",
                      "width"   => 40,
                      "height"  => 40,
                      "site_id" => 0
                    ),true);
                    
                    $image_big = get_new_image(array(
                      "url"     => cfg('upload_path_brand')."/".$val->brand_bg,
                      "folder"  => "brand",
                      "site_id" => 0
                    ),true);
                    
                  ?>
                    <a href="<?php echo $image_big;?>" title="Image Photo" class="act_modal" rel="700|400">
                      <img alt="" src="<?php echo $image_thumb;?>" style="height:25px;width:25px" class="img-polaroid">
                    </a>
                  <?php } ?>
                  <span class="help-block">Max 500kb</span>
                  
                
              </div>
              <div class="col-md-4">
              <label class="check"><input name="brand_bg_show" type="checkbox" id="brand_bg_show" <?php echo (isset($val->brand_bg_show)&& $val->brand_bg_show=="1")?'checked="checked"':'';?> class="icheckbox" /> Show Background</label>
              </div>
            </div>
            
            <div class="row form-group">  
              <div class="col-md-3 control-label">Info Title</div>
              <div class="col-md-7">
                <input type="text" id="brand_front_title" name="brand_front_title" class="validate[required] form-control" value="<?php echo isset($val->brand_front_title)?$val->brand_front_title:'';?>" />
              </div>
            </div>
            
            <div class="row form-group">  
              <div class="col-md-3 control-label">Info Description</div>
              <div class="col-md-7">
                
                <textarea id="brand_front_desc" name="brand_front_desc" class="form-control"><?php echo isset($val->brand_front_desc)?$val->brand_front_desc:'';?></textarea>
                
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
            <button type="submit" name="btn_simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
          </div>
        </div>

</form>
