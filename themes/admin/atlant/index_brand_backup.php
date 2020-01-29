<?php js_hight_chart(); ?>
<div class="row" style="margin-top:20px;">
    
    
    <div class="col-md-3">

        <div class="widget widget-primary widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-globe"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count"><?php echo get_total_saldo($this->jCfg['user']['brand']);?></div>
                <div class="widget-title">Saldo</div>
                <div class="widget-subtitle">Saldo Campaign</div>
            </div>                           
        </div>

    </div>

    <div class="col-md-3">
                            
        <!-- START WIDGET REGISTRED -->
        <div class="widget widget-default widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-user"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count"><?php echo get_total_visitor(date("Y-m-d"),$this->jCfg['user']['brand']);?></div>
                <div class="widget-title">Sessions</div>
                <div class="widget-subtitle">Total Sessions Today</div>
            </div>                          
        </div>                            
        <!-- END WIDGET REGISTRED -->
        
    </div>

    <div class="col-md-3">

        <div class="widget widget-success widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-globe"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count"><?php echo get_total_visitor(date("Y-m-d"),$this->jCfg['user']['brand'],2);?></div>
                <div class="widget-title">Granted</div>
                <div class="widget-subtitle">Total Connection Granted Today</div>
            </div>                           
        </div>

    </div>


    <div class="col-md-3">

        <div class="widget widget-warning widget-item-icon">
            <div class="widget-item-left">
                <span class="fa fa-globe"></span>
            </div>
            <div class="widget-data">
                <div class="widget-int num-count"><?php echo get_views_campaign($this->jCfg['user']['brand']);?></div>
                <div class="widget-title">Views</div>
                <div class="widget-subtitle">Total Views Campaign</div>
            </div>                           
        </div>

    </div>

    <div class="col-md-8">
        
        <div class="panel" style="height:300px;padding:10px;" id="series_date">
            
        </div>

    </div>
    <div class="col-md-4">
        
        <!--<div class="panel" style="height:300px;padding:10px;" id="pie_type_auth">
            
        </div>-->

    </div>

</div>


<script type="text/javascript">
$(document).ready(function(){

    //$('#panel-content-wrap').removeClass('panel');
    //$('#border-header').css('border','none');
    //$('#row-after-header').remove();

}); 



$(function () {
    // Build the chart
    $('#pie_type_auth').highcharts({
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
            text: '<b>Member Authentication Type</b>'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        colors: ['#999999','#3b5998','#dc4a38','#3EA7DA'],
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
                        distance: 2,
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
                foreach ((array)get_pie_type_auth() as $k => $v) {
                   echo $k==0?"":",";
                   echo "['".$v->type."',".$v->jumlah."]";
                }?>
            ]
        }]
    });
});


$('#series_date').highcharts({
    chart: {
        type: 'area'
    },
    title: {
        text: 'Visitors ads by date last 30 day'
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
            text: 'Total'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%e. %b}: {point.y:.f} visitor'
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
        name:'Visitor',
        data: [
            <?php 
            $data_byday = get_visitor_date($this->jCfg['user']['brand']);
            foreach ((array)$data_byday as $k => $v) {
               $koma = $k<count($data_byday)-1?",":"";
               $dm = explode("-", $v->tanggal);
               echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".$v->jumlah."]".$koma."
               ";
            }?>
        ]
    }]
});
</script>