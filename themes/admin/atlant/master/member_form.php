<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 

        <input type="hidden" name="member_id" id="member_id" value="<?php echo isset($val->member_id)?$val->member_id:'';?>" />

        <div class="row">
          <div class="col-md-6">
            <h3 class="heading-form">Info Data Member</h3>
            
            <div class="row form-group">  
              <div class="col-md-3 control-label">Nama Member</div>
              <div class="col-md-9">
                <input type="text" id="member_name" name="member_name" class="validate[required] form-control" value="<?php echo isset($val->member_name)?$val->member_name:'';?>" />
              </div>
            </div>
            
            <div class="row form-group">  
              <div class="col-md-3 control-label">Jenis Kelamin</div>
              <div class="col-md-5">
                
                <select name="member_gender" id="member_gender" class="form-control select">
                  <?php
                  foreach ((array)cfg('gender') as $k1 => $v1) {
                      $slc = isset($val)&&$val->member_gender==$k1?'selected="selected"':'';
                      echo "<option value='".$k1."' $slc >".$v1."</option>";
                  }
                  ?>
                </select>


              </div>
            </div>
            
            <div class="row form-group">  
              <div class="col-md-3 control-label">Tanggal Lahir</div>
              <div class="col-md-4">
                <input type="text" id="member_tgl_lahir" name="member_tgl_lahir" class="validate[required] form-control datepicker" value="<?php echo isset($val->member_tgl_lahir)?$val->member_tgl_lahir:'';?>" />
              </div>
            </div>

            <div class="row form-group">  
              <div class="col-md-3 control-label">Email</div>
              <div class="col-md-9">
                <input type="text" id="member_email" name="member_email" class="validate[required] form-control" value="<?php echo isset($val->member_email)?$val->member_email:'';?>" />
              </div>
            </div>


             <div class="row form-group">
                <div class="col-md-3 control-label">Provinsi</div>
                <div class="col-md-5">
                  <select class="form-control" name="member_provinsi" id="member_provinsi">
                    <option value=""> - PILIH  - </option>
                      <?php foreach((array)get_province() as $k=>$v){
                        $s = isset($val->member_provinsi)?$val->member_provinsi:'';
                        $c = ($s == $v->propinsi_id)?"selected='selected'":"";
                        echo "<option value='".$v->propinsi_id."' $c >".$v->propinsi_nama."</option>";
                      }?>
                  </select>
                </div> 
              </div>

            <div class="row form-group">  
              <div class="col-md-3 control-label">Kota</div>
              <div class="col-md-5">
                  <select class="form-control" name="member_kota" id="member_kota">
                    <option value=""> - PILIH  - </option>

                  </select>
              </div>
            </div>

             <div class="row form-group">  
              <div class="col-md-3 control-label">Alamat</div>
              <div class="col-md-9">
                <textarea id="member_alamat" name="member_alamat" class="form-control" ><?php echo isset($val->member_alamat)?$val->member_alamat:'';?></textarea>
              </div>
            </div>

            <div class="row form-group">  
              <div class="col-md-3 control-label">Status</div>
              <div class="col-md-4">
                <select name="member_status" id="member_status" class="form-control select">
                  <?php
                  foreach ((array)cfg('status_data') as $k1 => $v1) {
                      $slc = isset($val)&&$val->member_status==$k1?'selected="selected"':'';
                      echo "<option value='".$k1."' $slc >".$v1."</option>";
                  }
                  ?>
                </select>
              </div>
            </div>


          </div>  

          <div class="col-md-6">
            
            <h3 class="heading-form">Info Login</h3>

            <div class="row form-group">  
              <div class="col-md-3 control-label">Login Type</div>
              <div class="col-md-5">
                
                <select name="member_sm_type" id="member_sm_type" class="form-control select">
                  <?php
                  foreach ((array)cfg('login_type') as $k1 => $v1) {
                      $slc = isset($val)&&$val->member_sm_type==$k1?'selected="selected"':'';
                      echo "<option value='".$k1."' $slc >".$v1."</option>";
                  }
                  ?>
                </select>


              </div>
            </div>

            <div class="row form-group">  
              <div class="col-md-3 control-label">User ID</div>
              <div class="col-md-6">
                <input type="text" id="member_sm_uid" name="member_sm_uid" class="form-control" value="<?php echo isset($val->member_sm_uid)?$val->member_sm_uid:'';?>" />
              </div>
            </div>

            <div class="row form-group">  
              <div class="col-md-3 control-label">User Name</div>
              <div class="col-md-6">
                <input type="text" id="member_sm_uname" name="member_sm_uname" class="form-control" value="<?php echo isset($val->member_sm_uname)?$val->member_sm_uname:'';?>" />
              </div>
            </div>

            
            <div class="row form-group">  
              <div class="col-md-3 control-label">Token</div>
              <div class="col-md-9">
                <textarea id="member_sm_token" rows="5" name="member_sm_token" class="form-control"><?php echo isset($val->member_sm_token)?$val->member_sm_token:'';?></textarea>

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

<script type="text/javascript">
 
  var AJAX_URL = '<?php echo site_url("ajax/data");?>';
  $(document).ready(function(){
    
    $('#member_provinsi').change(function(){
      get_city($(this).val());
    });

    <?php if( isset($val) ){ ?>
      get_city(<?php echo $val->member_provinsi;?>,<?php echo $val->member_kota;?>);
    <?php }else{ ?>
      get_city($('#member_provinsi').val(),'');
    <?php } ?>
  
  });
  function get_city(prov,city){
    city = city==undefined?'0':city;
    $.post(AJAX_URL+'/get_kota',{prov:prov,kota:city},function(o){
      $('#member_kota').html(o);
    });
  }


</script>
