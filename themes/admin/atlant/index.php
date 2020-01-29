<?php js_hight_chart(); ?>
<style type="text/css">
.tile{
	min-height: 10px;
}
</style>
<br />
<div class="row" style="margin-top:0px;">
    <div class="col-md-8">
        <div class="panel" style="height:350px;padding:10px;" id="line_chart"></div>
    </div>
    <div class="col-md-4">
        <div class="panel" style="height:350px;padding:10px;" id="pie_cart"></div>
    </div>
</div>
<div class="row" style="margin-top:0px;">
    <div class="col-md-8">
    	<table class="table table-hover table-bordered table-striped">
    	   <thead>
    	   	<tr><th colspan="2">STREAM DATA</th></tr>
    	   </thead>
	       <tbody>
	        <?php 
            $arr_color = array(
                    "netral" => "warning",
                    "positif"=> "success",
                    "negatif"=> "danger"
                );
	        if( count(get_stream()) > 0 ){
	            foreach((array)get_stream() as $r){
                    $type_sentiment = "default";
                    if( $r->is_sentiment == 1 ){
                        $type_sentiment = $arr_color[$r->sentiment];
                    }
	        ?>
	                <tr>
	                    <td>
	                    <img src="<?php echo $r->foto;?>" width="50" />
	                    </td>
	                    <td>
		                    <b><?php echo $r->user_name;?></b><br />
		                    <?php echo $r->text;?><br/><i><?php echo myDate($r->time_add,"d M Y H:i:s");?></i>
		                    <div class="btn-group pull-right">
                                <a href="#" data-toggle="dropdown" class="btn btn-<?php echo $type_sentiment;?> dropdown-toggle btn-sm" aria-expanded="false"><?php echo $r->is_sentiment==0?'Set Sentiment':$r->sentiment;?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/me/otomatis_sentiment').'?id='.$r->id.'&next='.current_url();?>">Otomatis</a></li>

                                    <li><a href="<?php echo site_url('admin/me/set_sentiment').'?s=netral&id='.$r->id.'&next='.current_url();?>">Netral</a></li>
                                    <li><a href="<?php echo site_url('admin/me/set_sentiment').'?s=positif&id='.$r->id.'&next='.current_url();?>">Positif</a></li>
                                    <li><a href="<?php echo site_url('admin/me/set_sentiment').'?s=negatif&id='.$r->id.'&next='.current_url();?>">Negatif</a></li>

                                </ul>
                            </div>
	                    </td>
	                </tr>
	        <?php } } ?>
	        </tbody>
	    </table>
    </div>
    <div class="col-md-4">
        	
        	<div class="col-md-12">
		        <a href="#" class="tile tile-default" style="font-size: 25px;">
                    <?php echo myNum(get_count_stream());?>
                    <p>Total Semua Stream</p>                            
                </a>
		    </div>

        	<div class="col-md-4">
		        <a href="#" class="tile tile-success" style="font-size: 18px;">
                    <?php echo myNum(get_count_stream(array('sentiment' =>'positif')));?>
                    <p>Positif</p>                            
                </a>
		    </div>

		    <div class="col-md-4">
		        <a href="#" class="tile tile-danger" style="font-size: 18px;">
                    <?php echo myNum(get_count_stream(array('sentiment' =>'negatif')));?>
                    <p>Negatif</p>                            
                </a>
		    </div>

		    <div class="col-md-4">
		        <a href="#" class="tile tile-info" style="font-size: 18px;">
                    <?php echo myNum(get_count_stream(array('sentiment' =>'netral')));?>
                    <p>Netral</p>                            
                </a>
		    </div>

    </div>
    <div class="col-md-4">
    	<div class="panel" style="height:250px;padding:10px;" id="line_chart_sentiment"></div>
    </div>
</div>

<script type="text/javascript">
    END_DATE = '<?php echo myDate($end,"m-d-Y",false);?>';
    START_DATE = '<?php echo myDate($start,"m-d-Y",false);?>';
    <?php
    $data_line = get_count_line(array(
            "start" => $start,
            "end"   => $end
        ));
    $data_line_positif = get_count_line(array(
            "start" => $start,
            "end"   => $end,
            "sentiment" => 'positif'
        ));
    $data_line_negatif = get_count_line(array(
            "start" => $start,
            "end"   => $end,
            "sentiment" => 'negatif'
        ));
    $data_line_netral  = get_count_line(array(
            "start" => $start,
            "end"   => $end,
            "sentiment" => 'netral'
        ));
    ?>
    $(document).ready(function(){
        $('#panel-content-wrap').css('background-color','transparent')
                                .css('box-shadow','none')
                                .css('margin-top','0px')
                                .css('padding','0px');
    });

    // Build the chart

    $(function () {
        $('#pie_cart').highcharts({
        	chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    plotShadow: true,
                    type: 'pie'
                },
            title: {
	            text: 'Semua Data Sentiment'
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
	                    enabled: false
	                },
	                showInLegend: true
	            }
	        },
	        series: [{
	            name: 'Brands',
	            colorByPoint: true,
	            data: [{
	                name: 'Positif',
	                color:'#82CEC3',
	                y: <?php echo get_count_stream(array('sentiment' => 'positif'));?>
	            }, {
	                name: 'Negatif',
                    y: <?php echo get_count_stream(array('sentiment' => 'negatif'));?>,
	                sliced: true,
	                color:'#F37E87',
	                selected: true
	            }, {
	                name: 'Netral',
                    y: <?php echo get_count_stream(array('sentiment' => 'netral'));?>,
	                color:'#FFB066'
	            }]
	        }]
        });
    });

    $(function () {
    $('#line_chart').highcharts({
        title: {
            text: 'Stream Data'
        },
        subtitle: {
            text: '<?php echo myDate($start, "d M Y");?> s/d <?php echo myDate($end, "d M Y")?>'
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
                text: 'Total'
            },
            min: 0,
            gridLineWidth: 0.2,
            gridLineDashStyle:'ShortDot',
            minorGridLineWidth: 0
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%e. %b}: {point.y:.f}'
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
        series: [{
                name: 'Stream Data',
                data: [
                    <?php 
                        foreach ((array)$data_line as $kvs1 => $val_s1) {
                           $koma = $kvs1<count($data_line)-1?",":"";
                           $dm = explode("-", $val_s1->tanggal);
                           echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".$val_s1->jumlah."]".$koma."";
                        }?>                
                    ]
            }]
    });
});

    $(function () {
    $('#line_chart_sentiment').highcharts({
        title: {
            text: 'Sentiment Data'
        },
        subtitle: {
            text: '<?php echo myDate($start, "d M Y");?> s/d <?php echo myDate($end, "d M Y")?>'
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
                text: ''
            },
            min: 0,
            gridLineWidth: 0.2,
            gridLineDashStyle:'ShortDot',
            minorGridLineWidth: 0
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%e. %b}: {point.y:.f}'
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
        series: [{
                name: 'Netral',
                color:'#FFB066',
                data: [
                    <?php 
                        foreach ((array)$data_line_netral as $kvs1 => $val_s1) {
                           $koma = $kvs1<count($data_line_netral)-1?",":"";
                           $dm = explode("-", $val_s1->tanggal);
                           echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".$val_s1->jumlah."]".$koma."";
                        }?>              ]
            },{
                name: 'Positif',
                color:'#82CEC3',
                data: [
                    <?php 
                        foreach ((array)$data_line_positif as $kvs1 => $val_s1) {
                           $koma = $kvs1<count($data_line_positif)-1?",":"";
                           $dm = explode("-", $val_s1->tanggal);
                           echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".$val_s1->jumlah."]".$koma."";
                        }?>                ]
            },{
                name: 'Negatif',
                color:'#F37E87',
                data: [
                    <?php 
                        foreach ((array)$data_line_negatif as $kvs1 => $val_s1) {
                           $koma = $kvs1<count($data_line_negatif)-1?",":"";
                           $dm = explode("-", $val_s1->tanggal);
                           echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".$val_s1->jumlah."]".$koma."";
                        }?>                ]
            }]
    });
});


</script>