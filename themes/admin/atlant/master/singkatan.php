<?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data <?php echo isset($title)?$title:'';?></h3>
            <span>Data <?php echo isset($title)?$title:'';?> dari <?php echo cfg('app_name');?></span>
        </div>                                    
        <ul class="panel-controls" style="margin-top: 2px;">
            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
            <li><a href="<?php echo current_url();?>" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>                                       
        </ul>
    </div>
    <div class="panel-body panel-body-table">

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th width="220">Singkatan</th>
                    <th>Arti</th>
                    <th width="100">#Action</th>
                </tr>
                </thead>
               <tbody>
                <?php 
                if( count($data) > 0 ){
                    foreach((array)$data as $r){
                ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->sk_singkatan;?></td>
                            <td><?php echo $r->sk_panjang;?></td>
                            <td>
                                <?php link_action($links_table_item,"?_id="._encrypt($r->sk_id));?>
                            </td>
                        </tr>
                <?php } } ?>
                </tbody>
            </table>
            </div>
    </div>
</div>

<div class="pull-right">
            <?php echo isset($paging)?$paging:'';?>
</div>
