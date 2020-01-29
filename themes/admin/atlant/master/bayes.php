<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="" class="form-horizontal" method="post"> 
        <div class="row">
          <div class="col-md-12">
            <table class="table table-hover table-bordered table-striped">
              <tr>
                <td>Masukan Kalimat yang akan di cek sentimennya</td>
              </tr>
              <tr>
                <td>
                  <textarea id="text" name="text" class="form-control" ></textarea>
                </td>
              </tr>
              <tr>
                <td align="right"><button type="submit" name="proses" class="btn btn-primary btn-cons"><i class="icon-ok"></i> CEK  SENTIMENT</button></td>
              </tr>
              <?php if(isset($hasil)){?>
              <tr>
                <td>HASIL SENTIMENT</td>
              </tr>
              <tr>
                <td><u>Kalimat Asli</u></td>
              </tr>
              <tr>
                <td>&rarr; <?php echo isset($text)?$text:'';?></td>
              </tr>
              <tr>
                <td><u>Kalimat Hasil Stemming</u></td>
              </tr>
              <tr>
                <td>&rarr; <?php echo isset($stemming)?$stemming:'';?></td>
              </tr>
              <tr>
                <td><u>Hasil </u></td>
              </tr>
              <?php if( isset($hasil) && count($hasil)>0 ){
                    foreach((array)$hasil as $k=>$v){?>
              <tr>
                <td>&rarr; <?php echo $k." : ".$v;?></td>
              </tr>
              <?php } 
              }
              ?>

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

