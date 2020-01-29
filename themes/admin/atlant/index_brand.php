<style type="text/css">
    .widget{
        border-radius: 4px;
        box-shadow:0 0px 1px 0 rgba(0, 0, 0, 0.2);
    }
    .spark-line{
        margin-bottom: 10px;
        margin-top: -10px;
    }
    .widget-warning{
        background-color: #588C73;
    }
    .item-summary-info{
        border-right: 1px solid #eee;
        height: 80px;
        font-size: 20px;
    }
    .item-summary-info:last-child{
        border:none;
    }
    h2.title-item{
        color: #aaa;
        font-size: 20px;
        font-weight:100;
    }
    .item-summary-info h3{
        text-align: center;
        font-size: 30px;
        padding: 0px;
        margin:0px;
        color: #666;    
    }
    .item-summary-info p{
        color: #ccc;
        font-size: 12px;
        font-weight:100;
        text-transform: uppercase;
        text-align: center;
    }

</style>
<?php
js_hight_chart();
$par_pie = array();
if(  $this->jCfg['user']['is_all'] != 1 ){
    $par_pie['brand'] = $this->jCfg['user']['brand'];
}

$pie_data = item_pie_data($par_pie);

//get total visitor..
$total_visitor_par = array(
            "start"    => $start,
            "end"      => $end
    );
if( $this->jCfg['user']['is_all'] != 1 ){
    $total_visitor_par['brand'] = $this->jCfg['user']['brand'];
} 
$total_visitor = data_log($total_visitor_par);
$total_visitor = isset($total_visitor[0])?$total_visitor[0]->jumlah:0;

//get total views campaign.
$total_views_par = array(
        "start"    => $start,
        "end"      => $end
    );
if( $this->jCfg['user']['is_all'] != 1 ){
    $total_views_par['brand'] = $this->jCfg['user']['brand'];
} 
$total_views_campaign = get_views_campaign($total_views_par);

//total visitor granted
$total_visitor_granted = 0;
$total_granted_par = array(
            "status"   => 2,
            "start"    => $start,
            "end"      => $end
    );
if( $this->jCfg['user']['is_all'] != 1 ){
    $total_granted_par['brand'] = $this->jCfg['user']['brand'];
} 
$total_granted = data_log($total_granted_par);
$total_granted = isset($total_granted[0])?$total_granted[0]->jumlah:0;

//data series log..
$series_par = array(
        "start"    => $start,
        "end"      => $end
    );
if( $this->jCfg['user']['is_all'] != 1 ){
    $series_par['brand'] = $this->jCfg['user']['brand'];
} 
$series_data = get_series_log($series_par);

//selft hotspot.
if( $this->jCfg['user']['is_all'] != 1 ){
    
    $self_impression = self_impression(array(
        "start"    => $start,
        "end"      => $end,
        "brand" => $this->jCfg['user']['brand']
    ));
    $wifipro_impression = self_impression(array(
        "start"         => $start,
        "end"           => $end,
        "brand"         => $this->jCfg['user']['brand'],
        "is_opposite"   => true
    ));

    $self_ctr = self_ctr(array(
        "start"     => $start,
        "end"       => $end,
        "brand"     => $this->jCfg['user']['brand']
    ));
    $wifipro_ctr = self_ctr(array(
        "start"     => $start,
        "end"       => $end,
        "brand"     => $this->jCfg['user']['brand'],
        "is_opposite"   => true
    ));

    $self_fillrate = self_fillrate(array(
        "start"     => $start,
        "end"       => $end,
        "brand"     => $this->jCfg['user']['brand']
    ));
    $wifipro_fillrate = self_fillrate(array(
        "start"     => $start,
        "end"       => $end,
        "brand"     => $this->jCfg['user']['brand'],
        "is_opposite"   => true
    ));
    $earning_data = earning_data(array(
        "start"     => $start,
        "end"       => $end,
        "brand"     => $this->jCfg['user']['brand']
    ));
    $expenditur_data = expenditur_data(array(
        "start"     => $start,
        "end"       => $end,
        "brand"     => $this->jCfg['user']['brand']
    ));

}
?>


<div class="row" style="margin-top:10px;">
    
    <?php if( $this->jCfg['user']['is_all'] != 1 ){?>
    <div class="col-md-3">

        <div class="widget widget-danger widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-dollar"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count"><?php echo get_total_saldo($this->jCfg['user']['brand']);?></div>
                <div class="widget-title">Saldo</div>
                <div class="widget-subtitle">Current Saldo Campaign</div>
            </div>                           
        </div>

    </div>
    <?php }else{ ?>
    <div class="col-md-3">

        <div class="widget widget-info widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-bell-o"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count"><?php echo get_total_brand();?></div>
                <div class="widget-title">Brand</div>
                <div class="widget-subtitle">Total Brand</div>
            </div>                           
        </div>

    </div>
    <?php } ?>

    <div class="col-md-3">
                            
        <!-- START WIDGET REGISTRED -->
        <div class="widget widget-default widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-group"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count"><?php echo $total_visitor;?></div>
                <div class="widget-title">Sessions</div>
                <div class="widget-subtitle">Total Sessions</div>
            </div>                          
        </div>                            
        <!-- END WIDGET REGISTRED -->
        
    </div>

    <div class="col-md-3">

        <div class="widget widget-warning widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-eye"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count"><?php echo $total_views_campaign;?></div>
                <div class="widget-title">Views</div>
                <div class="widget-subtitle">Total Views Campaign</div>
            </div>                           
        </div>

    </div>
    
    <div class="col-md-3">

        <div class="widget widget-success widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-check-circle-o"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count"><?php echo $total_visitor_granted;?></div>
                <div class="widget-title">Granted</div>
                <div class="widget-subtitle">Total Connection Granted</div>
            </div>                           
        </div>

    </div>


</div>
<div class="row" style="margin-top:0px;">
    <div class="col-md-12">
        <div class="panel" style="height:350px;padding:10px;" id="series_date"></div>
    </div>
</div>

<?php if( $this->jCfg['user']['is_all'] != 1 ){ ?>
<div class="row" style="margin-top:0px;">
    <div class="col-md-12">
        <div class="panel" style="height:150px;padding:10px;">
            <h2 class="title-item">Self-Promotion Campaigns summary</h4>
            <div class="col-md-3 item-summary-info">
                <h3><?php echo myNum($self_impression);?></h3>
                <p>Impression</p>
            </div>
            <div class="col-md-3 item-summary-info">
                <h3><?php echo myNum($self_ctr);?>%</h3>
                <p>CTR</p>
            </div>
            <div class="col-md-3 item-summary-info">
                <h3><?php echo myNum($self_fillrate);?>%</h3>
                <p>Local Fill rate</p>
            </div>
            <div class="col-md-3 item-summary-info">
                <h3><span style="color:#ccc;">Rp.</span><?php echo myNum($expenditur_data);?></h3>
                <p>Expenditur</p>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top:0px;">
    <div class="col-md-12">
        <div class="panel" style="height:150px;padding:10px;">
            <h2 class="title-item">Wifipro Media Network summary</h4>
            <div class="col-md-3 item-summary-info">
                <h3><?php echo myNum($wifipro_impression);?></h3>
                <p>Impressions</p>
            </div>
            <div class="col-md-3 item-summary-info">
                <h3><?php echo myNum($wifipro_ctr);?>%</h3>
                <p>CTR</p>
            </div>
            <div class="col-md-3 item-summary-info">
                <h3><?php echo myNum($wifipro_fillrate);?>%</h3>
                <p>Fill Rate</p>
            </div>
            <div class="col-md-3 item-summary-info">
            <h3><span style="color:#ccc;">Rp.</span><?php echo myNum($earning_data);?></h3>
                <p>Earnings</p>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="row" style="margin-top:0px;">
    
    <?php foreach ((array)$pie_data as $k => $v) { ?>
    <div class="col-md-4">
        <div class="panel" style="height:250px;padding:10px;" id="pie_chart_<?php echo $k;?>"></div>
    </div>
    <?php } ?>

</div>

<script type="text/javascript">
    START_DATE = '<?php echo myDate($start,"m-d-Y",false);?>';
    END_DATE = '<?php echo myDate($end,"m-d-Y",false);?>';
    $(document).ready(function(){
        $('#panel-content-wrap').css('background-color','transparent')
                                .css('box-shadow','none')
                                .css('margin-top','0px')
                                .css('padding','0px');
    });

    <?php foreach ((array)$pie_data as $k => $v) {
            $data_par = array(
                "group_by" => $v['group_by'],
                "start"    => $start,
                "end"      => $end
            );
            if( $this->jCfg['user']['is_all'] != 1 ){
                $data_par['brand'] = $this->jCfg['user']['brand'];
            } 
            $data_pie = data_log($data_par);
        ?>
        
        $(function () {
            $('#pie_chart_<?php echo $k;?>').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    plotShadow: true
                },
                title: {
                    text: '<?php echo $v["title"];?>',
                    align: 'center',
                    verticalAlign: 'middle',
                    y: 50
                },
                colors: <?php echo isset($v['colors'])?$v['colors']:"['#91B458','#FE9E1A','#AC4241']";?>,
                credits: {
                    enabled:false
                },
                exporting:{
                    enabled:false
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        dataLabels: {
                            enabled: false,
                            distance: -20,
                            style: {
                                color: 'white'
                            }
                        },
                        showInLegend: true,
                        startAngle: -90,
                        endAngle: 90,
                        center: ['50%', '75%']
                    }
                },
                series: [{
                    type: 'pie',
                    name: '<?php echo $v["title"];?>',
                    innerSize: '50%',
                    data: [
                        <?php 
                        foreach ((array)$data_pie as $k1 => $v1) {
                           echo $k1==0?"":",";
                           if( !isset($v['masking']) ){
                                $nama = trim($v1->nama)==""?'n/a':$v1->nama;
                                echo "['".$nama."',".$v1->jumlah."]";
                           }else{
                                $masking = $v['masking'];
                                $nama = isset($masking[$v1->nama])?$masking[$v1->nama]:$v1->nama;
                                $nama = trim($nama)==""?'n/a':$nama;
                                echo "['".$nama."',".$v1->jumlah."]";
                           }
                        }?>
                    ]
                }]
            });
        });

    <?php }?>
    $(function () {
        $('#series_date').highcharts({
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            colors:["#588C73","#F2E394","#D96459","#0B486B","#EFF3DA","#C7E466"],
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                title: {
                    text: ''
                }
            },
            credits: {
                enabled:false
            },
            exporting:{
                enabled:false
            },
            yAxis: {
                title: {
                    text: 'Total Sessions'
                },
                min: 0,
                gridLineWidth: 0.2,
                gridLineDashStyle:'ShortDot',
                minorGridLineWidth: 0
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x:%e. %b}: {point.y:.f} visitor'
            },

            plotOptions: {
                area: {
                    marker: {
                        enabled: false,
                        symbol: 'circle',
                        radius: 2,
                        states: {
                            hover: {
                                enabled: true
                            }
                        }
                    },
                    fillOpacity:0.7
                },
                enableMouseTracking: true
            },
            legend:{
                enabled:true
            },
            series: [
            <?php 
            $idx=0;
            foreach((array)$series_data as $ks=>$vs){
                echo $idx!=0?',':'';
                $idx++;
                ?>
                {
                    name:'<?php echo $ks;?>',
                    type: 'area',
                    data: [
                        <?php 
                        foreach ((array)$vs as $kvs1 => $val_s1) {
                           $koma = $kvs1<count($vs)-1?",":"";
                           $dm = explode("-", $val_s1['tanggal']);
                           echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".$val_s1['jumlah']."]".$koma."";
                        }?>
                    ]
                }
            <?php  } ?>
            ]
        });
    });


/*$(function () {
    var imp_7day_self_value = [100,210,332,223,90,51,94,90,121,256];
    $('#imp_7day_self').sparkline(imp_7day_self_value, {type: 'bar', barColor: '#588C73',barWidth:10,height:40} );
});*/

</script>




