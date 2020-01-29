<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 

        <input type="hidden" name="sk_id" id="sk_id" value="<?php echo isset($val->sk_id)?$val->sk_id:'';?>" />

        <div class="row">
          <div class="col-md-12">
            
            <div class="row form-group">  
              <div class="col-md-3 control-label">Singkatan</div>
              <div class="col-md-3">
                <input type="text" id="sk_singkatan" name="sk_singkatan" class="validate[required] form-control" value="<?php echo isset($val->sk_singkatan)?$val->sk_singkatan:'';?>" />
              </div>
            </div>

            <div class="row form-group">  
              <div class="col-md-3 control-label">Arti Singkatan</div>
              <div class="col-md-9">
                <input type="text" id="sk_panjang" name="sk_panjang" class="validate[required] form-control" value="<?php echo isset($val->sk_panjang)?$val->sk_panjang:'';?>" />
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
            <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
          </div>
        </div>

</form>

