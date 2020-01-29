<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="" class="form-horizontal" method="post"> 
        <div class="row">
          <div class="col-md-12">
            <table class="table table-hover table-bordered table-striped">
              <tr>
                <td>Masukan Kalimat/Kata yang akan di stemming</td>
              </tr>
              <tr>
                <td>
                  <textarea id="text" name="text" class="form-control" ></textarea>
                </td>
              </tr>
              <tr>
                <td align="right"><button type="submit" name="proses" class="btn btn-primary btn-cons"><i class="icon-ok"></i> TEST STIMMING</button></td>
              </tr>
              <?php if(isset($original)){?>
              <tr>
                <td>HASIL STEMMING</td>
              </tr>
              <tr>
                <td><u>Kalimat Asli</u></td>
              </tr>
              <tr>
                <td>&rarr; <?php echo isset($original)?$original:'';?></td>
              </tr>
              <tr>
                <td><u>Kalimat Hasil Stemming</u></td>
              </tr>
              <tr>
                <td>&rarr; <?php echo isset($hasil)?$hasil:'';?></td>
              </tr>
              <?php } ?>
              
            </table>

          </div>  
        </div>
        <br />
        
        <div class="panel-footer">
          <div class="pull-left">
            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Kembali</button>
          </div>
          <div class="pull-right">
            
          </div>
        </div>

</form>

