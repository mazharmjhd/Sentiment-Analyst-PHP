<?php
$type = isset($_GET['type'])?$_GET['type']:1;
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
    </style>
    <?php
    js_hight_chart();
    ?>
</head>
<body>

<?php if($type == 1){?>
<div class="row">
    
    <div class="col-md-12">
        <div style="height:45px;padding:10px;">
            <center><h2>Data Harian Tanggal <?php echo date("d M Y");?> KE - <?php echo isset($_GET["t"])?$_GET["t"]:1;?></h2></center>
        </div>
        <br />
    </div>
    <div class="col-md-6">
        <div class="panel" style="height:350px;padding:10px;" id="line2">
            
        </div>
    </div>


    <div class="col-md-4">
        <div class="panel" style="height:350px;padding:10px;" id="col_1">
            
        </div>
    </div>
    <div class="col-md-2">
        <a class="tile tile-warning" href="#">
            <?php echo get_count_data();?>                <p>Total Data Sampai hari Ini</p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>

        <a class="tile tile-info" href="#">
            <?php echo get_count_data(date("Y-m-d"));?>                <p>Total Data Hari Ini</p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>

        <a class="tile tile-success" href="#">
            <?php echo get_count_section();?>                <p>Total Seksi</p>                            
            <div class="informer informer-default dir-tr"><span class="fa fa-calendar"></span></div>
        </a>
        
    </div>

    <div class="col-md-4">
        <div class="panel" style="height:380px;padding:10px;" id="pie1">
            
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel" style="height:380px;padding:10px;" id="line_x">
            
        </div>
    </div>

    

</div>
<?php } ?>

<script type="text/javascript">
var INTERVAL = <?php echo cfg('interval_waktu');?>;
var TYPE = "<?php echo isset($_GET['t'])?$_GET['t']:1;?>";
var CURR_URL = '<?php echo site_url();?>';

$(document).ready(function(){
    $('#panel-content-wrap').removeClass('panel');
    $('#border-header').css('border','none');
    go_to_dashboard();
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



$(function () {
            $('#col_1').highcharts({
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Jumlah Data Yang Di Input'
                },
                xAxis: {
                    categories: ['CAMI', 'INTIM', 'MOMENT', 'RESORT', 'PICES']
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
                    name: 'Approve',
                    data: [5, 3, 4, 7, 2]
                }, {
                    name: 'Reject',
                    data: [1, 2, 1, 2, 3]
                }]
            });
        });

$(function () {

    $(document).ready(function () {

        // Build the chart
        $('#pie1').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Total Data Per Hari Ini'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Cami',
                    y: 56.33
                }, {
                    name: 'Intim',
                    y: 24.03,
                    sliced: true,
                    selected: true
                }, {
                    name: 'Moment',
                    y: 10.38
                }, {
                    name: 'Resort',
                    y: 4.77
                }, {
                    name: 'Pices',
                    y: 0.91
                }, {
                    name: 'Others',
                    y: 0.2
                }]
            }]
        });
    });
});

$(function () {
    $('#line2').highcharts({
        chart: {
            type: 'area'
        },
        title: {
            text: 'Total Target Hari Ini'
        },
        subtitle: {
            text: 'Source: Data Per Seksi'
        },
        xAxis: {
            categories: ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00']
        },
        yAxis: {
            title: {
                text: 'Jumlah'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineWidth: 2
                }
            }
        },
        series: [{
            name: 'Target',
            color: Highcharts.getOptions().colors[0],
            data: [40,40, 40, 40, 40, 40]

        }, {
            name: 'Pencapian',
            color: Highcharts.getOptions().colors[2],
            data: [ 5, 15, 20, 25, 33, 39]
        }]
    });
});

$(function () {
    $('#line_x').highcharts({
        title: {
            text: 'Summary Semua Data'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Maret', 'April', 'Mei']
        },
        labels: {
            items: [{
                html: 'Total Data',
                style: {
                    left: '50px',
                    top: '18px',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }]
        },
        series: [{
            type: 'column',
            name: 'CAMI',
            data: [3, 2, 1, 3, 4]
        }, {
            type: 'column',
            name: 'INTIM',
            data: [2, 3, 5, 7, 6]
        }, {
            type: 'column',
            name: 'MOMENT',
            data: [4, 3, 3, 9, 4]
        }, {
            type: 'column',
            name: 'RESORT',
            data: [3, 2, 5, 6, 2]
        }, {
            type: 'column',
            name: 'PICES',
            data: [3, 2, 4, 7, 3]
        }, {
            type: 'spline',
            name: 'Average',
            data: [3, 2.67, 3, 6.33, 3.33],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[3],
                fillColor: 'white'
            }
        }, {
            type: 'pie',
            name: 'Total',
            data: [{
                name: 'Cami',
                y: 13,
                color: Highcharts.getOptions().colors[0] // Jane's color
            }, {
                name: 'Intim',
                y: 23,
                color: Highcharts.getOptions().colors[1] // John's color
            }, {
                name: 'Moment',
                y: 19,
                color: Highcharts.getOptions().colors[2] // Joe's color
            }, {
                name: 'Resort',
                y: 8,
                color: Highcharts.getOptions().colors[3] // Joe's color
            }, {
                name: 'Pices',
                y: 9,
                color: Highcharts.getOptions().colors[4] // Joe's color
            }],
            center: [100, 80],
            size: 100,
            showInLegend: false,
            dataLabels: {
                enabled: false
            }
        }]
    });
});

</script>

</body>
</html>