<?php
$type = isset($_GET['t'])?$_GET['t']:1;
//debugCode(get_summary_byday_month());
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mandiri Dashboard</title>
    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo themeUrl();?>css/theme-default.css"/>
    <script type="text/javascript" src="<?php echo themeUrl();?>js/plugins/jquery/jquery.min.js"></script>
    <style type="text/css">
    body{
        padding:0px;
        margin:10px;
    }
    .gradient{
        background: rgba(255,255,255,1);
        background: -moz-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
        background: -webkit-gradient(left top, right top, color-stop(0%, rgba(255,255,255,1)), color-stop(47%, rgba(246,246,246,1)), color-stop(100%, rgba(237,237,237,1)));
        background: -webkit-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
        background: -o-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
        background: -ms-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
        background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed', GradientType=1 );
      }
      img.img-logo{
        margin:10px;
        margin-top: 0px;
      }
    </style>
    <?php
    js_hight_chart();
    ?>
</head>
<body>

<?php if($type == 1){?>
<div class="row">
    
    <div class="col-md-2">
        <img src="<?php echo themeUrl();?>images/logo-eco.png" class="img-logo" height="40" />
    </div>
    <div class="col-md-8">
        <center><h3>Dashboard Kinerja Wholesale & E-Banking Operations Department</h3>
        <h3>Data January s.d <?php echo myDate(mDate(cfg('today'),'-1 month','Y-m-d'),"F Y",false);?></h3>
        </center>
    </div>
    <div class="col-md-2" style="text-align:right;">
        <img src="<?php echo themeUrl();?>images/logo-mio.png" class="img-logo" height="40" />
    </div>

    <div class="col-md-6">
        <div class="panel" style="height:340px;padding:10px;" id="cart_bar_pencapaian">
            
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="panel" style="height:340px;padding:10px;" id="cart_pie_section">
            
        </div>
    </div>

    <div class="col-md-2">
        <a class="tile tile-warning" style="background-color:#FF7600;" href="#">
            <?php echo get_count_data();?>                <p>Total Data Sampai Tanggal <?php echo myDate(cfg('today'),'d M Y',false);?></p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>

        <a class="tile tile-info" href="#">
            <?php echo get_count_data(cfg('today'));?>                <p>Total Data Tanggal <?php echo myDate(cfg('today'),'d M Y',false);?></p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>

        <a class="tile tile-success" href="#" style="background-color:#08265F;">
            <?php echo get_count_section();?>                <p>Total Seksi</p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>
        
    </div>

    

    <div class="col-md-12">
        <div class="panel" style="height:300px;padding:10px;" id="colum_summary_bulan">
            
        </div>
    </div>
</div>
<?php } ?>

<?php if($type == 2){?>
<div class="row">

    <div class="col-md-2">
        <img src="<?php echo themeUrl();?>images/logo-eco.png" class="img-logo" height="40" />
    </div>
    <div class="col-md-8">
        <center><h3>Dashboard Kinerja Wholesale & E-Banking Operations Department</h3>
        <h3>Data Bulan <?php echo myDate(cfg('today'),"F Y",false);?></h3>
        </center>
    </div>
    <div class="col-md-2" style="text-align:right;">
        <img src="<?php echo themeUrl();?>images/logo-mio.png" class="img-logo" height="40" />
    </div>

    <div class="col-md-12">
        <div class="panel" style="height:300px;padding:10px;" id="cart_summary_month">
            
        </div>
    </div>

    

    <div class="col-md-4">
        <div class="panel" style="height:340px;padding:10px;" id="cart_pie_section">
            
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="panel" style="height:340px;padding:10px;" id="cart_bar">
            
        </div>
    </div>
    
    <div class="col-md-2">
        <a class="tile tile-warning" style="background-color:#FF7600;" href="#">
            <?php echo get_count_data();?>                <p>Total Data Sampai Tanggal <?php echo myDate(cfg('today'),'d M Y',false);?></p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>

        <a class="tile tile-info" href="#">
            <?php echo get_count_data(cfg('today'));?>                <p>Total Data Tanggal <?php echo myDate(cfg('today'),'d M Y',false);?></p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>

        <a class="tile tile-success" href="#" style="background-color:#08265F;">
            <?php echo get_count_section();?>                <p>Total Seksi</p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>
        
    </div>
    
</div>
<?php } ?>

<?php if($type == 3){?>
<div class="row">
        
    <div class="col-md-2">
        <img src="<?php echo themeUrl();?>images/logo-eco.png" class="img-logo" height="40" />
    </div>
    <div class="col-md-8">
        <center><h3>Dashboard Kinerja Wholesale & E-Banking Operations Department</h3>
        <h3>Data Tanggal <?php echo myDate(cfg('today'),"d F Y",false);?></h3></center>
    </div>
    <div class="col-md-2" style="text-align:right;">
        <img src="<?php echo themeUrl();?>images/logo-mio.png" class="img-logo" height="40" />
    </div>

    <div class="col-md-10">
        <div class="panel" style="height:340px;padding:10px;" id="cart_bar_today">
            
        </div>
    </div>

    <div class="col-md-2">
        <a class="tile tile-warning" style="background-color:#FF7600;" href="#">
            <?php echo get_count_data();?>                <p>Total Data Sampai Tanggal <?php echo myDate(cfg('today'),'d M Y',false);?></p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>

        <a class="tile tile-info" href="#">
            <?php echo get_count_data(cfg('today'));?>                <p>Total Data Tanggal <?php echo myDate(cfg('today'),'d M Y',false);?></p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>

        <a class="tile tile-success" href="#" style="background-color:#08265F;">
            <?php echo get_count_section();?>                <p>Total Seksi</p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>
        
    </div>

    <div class="col-md-4">
        <div class="panel" style="height:300px;padding:10px;" id="cart_pie_section">
            
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel" style="height:300px;padding:10px;" id="cart_summary_today">
            
        </div>
    </div>
</div>
<?php } ?>


<script type="text/javascript">
var INTERVAL = <?php echo cfg('interval_waktu')*1000;?>;
var TYPE = "<?php echo isset($_GET['t'])?$_GET['t']:1;?>";
var CURR_URL = '<?php echo site_url("dashboard");?>';
$(document).ready(function(){
    <?php if(trim(cfg('roling_dashboard'))=="ya"){?>
    go_to_dashboard();
    <?php } ?>
}); 
function go_to_dashboard(){
    setTimeout(function(){ 
            TYPE = TYPE==3?0:TYPE;
            TYPE = parseInt(TYPE)+1;
            document.location = CURR_URL+'?t='+TYPE;
    }, INTERVAL);
}


$(function () {
 Highcharts.setOptions({
     colors: ['#08265F','#62B2E2','#FF7600','#FFD400','#BEB8B1', '#68AB9F', '#DECC8C', '#AB6890']
    });
});


<?php if($type == 3){?>

<?php
$bar_pencapaian = get_bar_pencapaian_section_day(cfg('today'));
$categories = array();
$pencapaian = array();
foreach ((array)$bar_pencapaian['section'] as $m => $n) {
   $categories[] = "'".$n->sec_name."'";
   $bagi = $n->jumlah;
   $x = isset($bar_pencapaian['pencapaian'][$n->sec_id])?$bar_pencapaian['pencapaian'][$n->sec_id]:0;
   $pencapaian[] = round($x,2);
}
?>
$(function () {
    $('#cart_summary_today').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<b>Realisasi SLA Perseksi Tanggal <?php echo myDate(cfg("today"),"d M Y",false);?></b>'
        },
        xAxis: {
            categories: [<?php echo implode(",",$categories);?>]
            //categories:['CAMI','INTIM','RESORT','PICES','MOMENT']
        },
        yAxis: {
            min: 0,
            title: {
                text: '(%)'
            }
        },
        legend: {
            reversed: true
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.y:.f} %'
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [
        {
            name: 'Realisasi',
            data: [<?php echo implode(",", $pencapaian);?>]
            //data:[99,98,100,99,99]
        }]
    });
});

$('#cart_summary_month').highcharts({
    chart: {
        type: 'area'
    },
    title: {
        text: '<b>Realisasi SLA  Tanggal <?php echo myDate(cfg("today"),"d F Y",false);?></b>'
    },
    subtitle: {
        text: ''
    },
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
            text: 'Jumlah'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%e. %b}: {point.y:.f} %'
    },

    plotOptions: {
        area: {
            marker: {
                enabled: true
            },
            fillOpacity:0.3
        },
        enableMouseTracking: false
    },
    legend:{
        enabled:false
    },
    series: [{
        name:'Realisasi',
        data: [
            <?php 
            $data_byday = get_summary_byday_month();
            foreach ((array)$data_byday['data'] as $k => $v) {
               $koma = $k<count($data_byday['data'])-1?",":"";
               $dm = explode("-", $v->tgl);
               $bagi = isset($data_byday['layanan'][$v->tgl])?$data_byday['layanan'][$v->tgl]:0;
               echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".(round($v->pencapaian/$bagi,2)*160)."]".$koma."
               ";
            }?>
        ]
    }]
});

<?php
$today = cfg('today');
$bar_chart = get_bar_section($today);
$categories = array();
$progress = array();
$approve = array();
foreach ((array)$bar_chart['section'] as $m => $n) {
   $categories[] = "'".$n->sec_name."'";
   $progress[] = isset($bar_chart['progress'][$n->sec_id])?$bar_chart['progress'][$n->sec_id]:0;
   $done[] = isset($bar_chart['done'][$n->sec_id])?$bar_chart['done'][$n->sec_id]:0;
}
?>
$(function () {
    $('#cart_bar_today').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: '<b>Jumlah Layanan Yang di Proses Tanggal <?php echo myDate(cfg("today"),"d F Y",false);?></b>'
        },
        xAxis: {
            categories: [<?php echo implode(",",$categories);?>]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Data'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'Progress',
            data: [<?php echo implode(",", $progress);?>]
        }, {
            name: 'Approve',
            data: [<?php echo implode(",", $done);?>]
        }]
    });
});


$(function () {
    // Build the chart
    $('#cart_pie_section').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        //colors:['#38B8E3','#FE9B13'],
        title: {
            text: ''
        },
        subtitle: {
            text: '<b>Data Layanan All Section Tanggal <?php echo myDate(cfg("today"),"d F Y",false);?></b>'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        credits: {
            enabled:false
        },
        exporting:{
            enabled:false
        },
        plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        distance: 5,
                        style :{
                            color:'#08265F',
                            fontSize:'13px'
                        },
                        padding:1,
                        formatter: function () {
                            return "<b>"+(this.y)+"</b><br/>("+Highcharts.numberFormat(this.percentage,0)+"%)";
                        }
                    },
                    showInLegend: true
                }
            },
        series: [{
            type: 'pie',
            name: 'Section',
            data: [
                <?php 
                $today = cfg('today');
                foreach ((array)get_pie_section_day($today) as $k => $v) {
                   echo $k==0?"":",";
                   echo "['".$v->section."',".$v->jumlah."]";
                }?>
            ]
        }]
    });
});

<?php } ?>

<?php if($type == 2){?>

$('#cart_summary_month').highcharts({
    chart: {
        type: 'area'
    },
    title: {
        text: '<b>Realisasi SLA <?php echo myDate(cfg("today"),"F Y",false);?></b>'
    },
    subtitle: {
        text: ''
    },
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
            text: '(%)'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%e. %b}: {point.y:.f} %'
    },

    plotOptions: {
        area: {
            marker: {
                enabled: true
            },
            dataLabels: {
                    enabled: true,
                    style :{
                        color:'#08265F',
                        fontSize:'10px'
                    },
                    padding:1,
                    formatter: function () {
                        return (this.y)+"%";
                    }
            },
            fillOpacity:0.3
        },
        enableMouseTracking: false
    },
    legend:{
        enabled:false
    },
    series: [{
        name:'Realisasi',
        data: [
            <?php 
            $data_byday = get_summary_byday_month();
            foreach ((array)$data_byday['data'] as $k => $v) {
               $koma = $k<count($data_byday['data'])-1?",":"";
               $dm = explode("-", $v->tgl);
               echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".(round($v->target,2))."]".$koma."
               ";
            }?>
        ]
    }]
});

<?php
$today = cfg('today');
$bar_chart = get_bar_section_month($today);
$categories = array();
$progress = array();
$approve = array();
foreach ((array)$bar_chart['section'] as $m => $n) {
   $categories[] = "'".$n->sec_name."'";
   $progress[] = isset($bar_chart['progress'][$n->sec_id])?$bar_chart['progress'][$n->sec_id]:0;
   $done[] = isset($bar_chart['done'][$n->sec_id])?$bar_chart['done'][$n->sec_id]:0;
}
?>
$(function () {
    $('#cart_bar').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: '<b>Layanan Yang di Proses <?php echo myDate(cfg("today"),"F Y",false);?></b>'
        },
        xAxis: {
            categories: [<?php echo implode(",",$categories);?>]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Layanan'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            },
            bar :{
                dataLabels: {
                        enabled: true,
                        style :{
                            color:'#fff',
                            fontSize:'11px'
                        },
                        formatter: function () {
                            return (this.y);
                        }
                }
            }
        },
        series: [{
            name: 'Progress',
            data: [<?php echo implode(",", $progress);?>]
        }, {
            name: 'Approve',
            data: [<?php echo implode(",", $done);?>]
        }]
    });
});


$(function () {
    // Build the chart
    $('#cart_pie_section').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        //colors:['#38B8E3','#FE9B13'],
        title: {
            text: ''
        },
        subtitle: {
            text: '<b>Data Layanan All Section <?php echo myDate(cfg("today"),"F Y",false);?></b>'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        credits: {
            enabled:false
        },
        exporting:{
            enabled:false
        },
        plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled:true,
                        style :{
                            color:'#08265F',
                            fontSize:'13px'
                        },
                        padding:1,
                        formatter: function () {
                            return "<b>"+(this.y)+"</b><br/>("+Highcharts.numberFormat(this.percentage,0)+"%)";
                        }
                    },
                    showInLegend: true,
                }
            },
        series: [{
            type: 'pie',
            name: 'Section',
            data: [
                <?php 
                $today = cfg('today');
                foreach ((array)get_pie_section_month($today) as $k => $v) {
                   echo $k==0?"":",";
                   echo "['".$v->section."',".$v->jumlah."]";
                }?>
            ]
        }]
    });
});

<?php } ?>

<?php if($type == 1){?>
<?php
$categories_bulan = get_str_last_month(cfg('today'));
$section_list = get_section_list();
$cbl = array();
$data_bulanan = array();
foreach ((array)$categories_bulan as $p1 => $q1) {
   $cbl[] = "'".$q1['name']."'";
   $tmp_bulanan = get_bar_pencapaian_section_month($q1['key']);
   foreach ((array)$tmp_bulanan['pencapaian'] as $k2 => $v2) {
      $sec_name = isset($section_list[$k2]->sec_name)?$section_list[$k2]->sec_name:'xx';
      $data_bulanan[$sec_name][$q1['key']][] = $v2;
   }
}
?>
$(function () {
    $('#colum_summary_bulan').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<b>Realisasi SLA All Section January s.d <?php echo mDate(cfg("today"),"-1 month","F Y")?></b>'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                <?php echo implode(",", $cbl);?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '(%)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}%</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                        enabled: false,
                        style :{
                            color:'#08265F',
                            fontSize:'10px'
                        },
                        formatter: function () {
                            return (this.y)+" %";
                        }
                }
            }
        },
        series: [
        <?php 
        $idx=0;
        foreach ((array)$data_bulanan as $o1 => $y1) {
            $item_data = array();
            foreach ((array)$y1 as $mk1 => $mv1) {
                $item_data[] = round($mv1[0],2);
            }
            echo "{
                name:'".$o1."',
                data:[".implode(',',$item_data)."]
            }";

            $idx++;
            if( count($data_bulanan)>$idx )
                echo ",";  
        }?> 
        ]
    });
});

$(function () {
    // Build the chart
    $('#cart_pie_section').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        subtitle: {
            text: '<b>Data Layanan Section January s.d <?php echo mDate(cfg("today"),"-1 month","F Y")?></b>'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        credits: {
            enabled:false
        },
        exporting:{
            enabled:false
        },
        plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        style :{
                            color:'#08265F',
                            fontSize:'13px'
                        },
                        formatter: function () {
                            return "<b>"+(this.y)+"</b><br/>("+Highcharts.numberFormat(this.percentage,0)+"%)";
                        }
                    },
                    showInLegend: true
                }
            },
        series: [{
            type: 'pie',
            name: 'Section',
            data: [
                <?php 
                foreach ((array)get_pie_section_last_month() as $k => $v) {
                   echo $k==0?"":",";
                   echo "['".$v->section."',".$v->jumlah."]";
                }?>
            ]
        }]
    });
});

 //line summary day
$('#cart_summary').highcharts({
    chart: {
        type: 'area'
    },
    title: {
        text: '<b>Realisasi Data 30 Hari Terakhir</b>'
    },
    subtitle: {
        text: ''
    },
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
            text: 'Jumlah'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%e. %b}: {point.y:.f} %'
    },

    plotOptions: {
        area: {
            marker: {
                enabled: true
            },
            fillOpacity:0.3
        },
        enableMouseTracking: false
    },
    legend:{
        enabled:false
    },
    series: [{
        name:'Realisasi',
        data: [
            <?php 
            $data_byday = get_summary_byday();
            foreach ((array)$data_byday['data'] as $k => $v) {
               $koma = $k<count($data_byday['data'])-1?",":"";
               $dm = explode("-", $v->tgl);
               $bagi = isset($data_byday['layanan'][$v->tgl])?$data_byday['layanan'][$v->tgl]:0;
               echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".(round($v->pencapaian/$bagi,2)*100)."]".$koma."
               ";
            }?>
        ]
    }]
});


<?php
$bar_pencapaian = get_bar_pencapaian_section();
$categories = array();
$pencapaian = array();

foreach ((array)$bar_pencapaian['section'] as $m => $n) {
   $categories[] = "'".$n->sec_name."'";
   $x = isset($bar_pencapaian['pencapaian'][$n->sec_id])?$bar_pencapaian['pencapaian'][$n->sec_id]:0;
   $pencapaian[] = round($x,2);
}
?>
$(function () {
    $('#cart_bar_pencapaian').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<b>Realisasi SLA All Section January s.d <?php echo mDate(cfg("today"),"-1 month","F Y")?></b>'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [<?php echo implode(",",$categories);?>]
        },
        yAxis: {
            min: 0,
            title: {
                text: '(%)'
            }
        },
        legend: {
            reversed: true
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.y:.f} %'
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            },
            column:{
                dataLabels: {
                        enabled: true,
                        style :{
                            color:'#FFF',
                            fontSize:'13px'
                        },
                        formatter: function () {
                            return (this.y)+"%";
                        }
                }
            }
        },
        series: [
        {
            name: 'Realisasi',
            data: [<?php echo implode(",", $pencapaian);?>]
        }]
    });
});
<?php } ?>

</script>

</body>
</html>