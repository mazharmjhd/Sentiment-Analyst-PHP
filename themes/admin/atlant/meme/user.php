
        <?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data User</h3>
            <span>Data User dari <?php echo cfg('app_name');?> (<?php echo $cRec;?>)</span>
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
                    <th width="50px">Photo</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th width="50">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    foreach($data as $r){
                            $role = array();
                            $get_role = get_role($r->user_id);
                            foreach ((array)$get_role as $key => $value) {
                                $role[] = $value->ag_group_name;
                            }
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td>
                                <a href="<?php echo get_image(base_url()."assets/collections/user/".$r->user_photo);?>" title="Photo <?php echo $r->user_name;?>" class="act_modal" rel="600|350">
                                    <img alt="" src="<?php echo get_image(base_url()."assets/collections/user/".$r->user_photo);?>" class="img-polaroid" style="height:30px;width:30px">
                                </a>
                            </td>
                            <td><?php echo $r->user_name;?></td>
                            <td><?php echo $r->user_fullname;?></td>
                            <td><?php echo $r->user_email;?></td>
                            <td><?php echo $r->user_telp;?></td>
                            <td><?php echo count($role)>0?implode(",",$role):'';?></td>
                            <td><?php echo ($r->user_status==1)?'<span class="label label-info">Aktif</span>':'<span class="label label-warning">Non Aktif</span>';?></td>
                            <td align="right">
                                <?php 
                                $except = array();
                                if($r->user_id==1)
                                    $except = array('delete','edit');
                                link_action($links_table_item,"?_id="._encrypt($r->user_id),$except);?>
                            </td>
                        </tr>
                <?php } 
                }
                ?>
                </tbody>
            </table>
            </div>
    </div>
</div>

<div class="pull-right">
            <?php echo isset($paging)?$paging:'';?>
</div>
