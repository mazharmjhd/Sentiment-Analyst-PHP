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
                    <th width="30px">Photo</th>
                    <th>Username</th>
                    <th>Text</th>
                    <th>Stemming</th>
                    <th>Stream Date</th>
                    <th>Sentiment</th>
                    <th>Status</th>
                    <th width="180">#Action</th>
                </tr>
                </thead>
               <tbody>
                <?php 
                if( count($data) > 0 ){
                    foreach((array)$data as $r){
                        $status_txt = "<span class='label label-info'>".$r->sentiment."</span>";
                        if( trim($r->sentiment) == 'positif' ){
                            $status_txt = "<span class='label label-success'>".$r->sentiment."</span>";
                        }

                        if( trim($r->sentiment) == 'negatif' ){
                            $status_txt = "<span class='label label-danger'>".$r->sentiment."</span>";
                        }

                ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td>
                            <img src="<?php echo $r->foto;?>" width="40" />
                            </td>
                            <td><?php echo $r->user_name;?></td>
                            <td><?php echo $r->text;?></td>
                            <td><?php echo $r->text_stemming;?></td>
                            <td><?php echo myDate($r->time_add,"d M Y H:i:s");?></td>
                            <td><b><?php echo $r->is_sentiment==0?'n/a':$status_txt;?></b></td>
                            <td><?php echo $r->is_sentiment==1?'<span class="label label-info">Done</span>':'<span class="label label-warning">Pending</span>';?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false"><i class="fa fa-cog"></i> <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?php echo site_url('admin/me/otomatis_sentiment').'?id='.$r->id.'&next='.current_url();?>">Otomatis</a></li>

                                        <li><a href="<?php echo site_url('admin/me/set_sentiment').'?s=netral&id='.$r->id.'&next='.current_url();?>">Netral</a></li>
                                        <li><a href="<?php echo site_url('admin/me/set_sentiment').'?s=positif&id='.$r->id.'&next='.current_url();?>">Positif</a></li>
                                        <li><a href="<?php echo site_url('admin/me/set_sentiment').'?s=negatif&id='.$r->id.'&next='.current_url();?>">Negatif</a></li>
                                        <li><a href="<?php echo site_url('admin/me/hapus_sentiment').'?id='.$r->id.'&next='.current_url();?>">Hapus</a></li>
                                    </ul>
                                </div>
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
