<div id="page-wrapper">
<?php
	$this->load->view('wms/wms_header');
?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-tint fa-fw"></i> Ketinggian Air
				</div>
				<div class="panel-body" id="water-level-chart">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-tint fa-fw"></i> Kekeruhan Air
				</div>
				<div class="panel-body" id="turbidity-chart">
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	$this->load->view('template/footer');
?>

<script src="<?=base_url()?>assets/js/plugins/highcharts/highcharts.js"></script>
<script src="<?=base_url()?>assets/js/plugins/highcharts/highcharts-more.js"></script>
<script src="<?=base_url()?>assets/js/plugins/highcharts/exporting.js"></script>
<script>
$(document).ready(function () {
	Highcharts.setOptions({
        global : {
            useUTC : false
        }
    });
    
	$.getJSON('<?=base_url()?>api/wms_today_turbidity', function(data) {
		var option1 = {
			chart: {
				renderTo: 'turbidity-chart',
				defaultSeriesType: 'spline',
				events: {
					load: requestData
				}
			},
			title: {
				text: 'Turbiditas'
			},
			xAxis: {
				type: 'datetime',
				tickPixelInterval: 50,
				maxZoom: 20 * 100
			},
			yAxis: {
				minPadding: 0.2,
				maxPadding: 0.2,
				title: {
					text: 'Nilai (%)',
					margin: 80
				}
			},
			series: [{
				name: 'Turbiditas',
				data: []
			}]
		};
		
        option1.series[0].data = data;
        var chart = new Highcharts.Chart(option1);
        
        function requestData() {
    	    $.ajax({
    	        url: '<?=base_url()?>api/wms_turbidity',
    	        success: function(point) {
    	            var series = chart.series[0],
    	                shift = series.data.length > 20,
    	                data_length = chart.series[0].xData.length - 1,
    	                data = chart.series[0].xData;
    	            
    	            if(data[data_length] != point[0]){
    	            	chart.series[0].addPoint(point, true, shift);
    	            }
    	            setTimeout(requestData, 1000);    
    	        },
    	        cache: false
    	    });
    	}
    });
	
    $('#water-level-chart').highcharts({
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: 'Water Level'
	    },
	    
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 3,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 200,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'cm'
	        },
	        plotBands: [{
	            from: 0,
	            to: 60,
	            color:  '#DF5353' // red
	        }, {
	            from: 60,
	            to: 120,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: 120,
	            to: 200,
	            color: '#55BF3B' // green
	        }]        
	    },
	
	    series: [{
	        name: 'Ketinggian',
	        data: [0],
	        tooltip: {
	            valueSuffix: ' cm'
	        }
	    }]
	
	}, 

	function (chart) {
		setInterval(function () {
			$.getJSON("<?=base_url()?>api/wms_realtime_value", function (data, textStatus) {
				var point = chart.series[0].points[0];
				point.update(data);
			});
		}, 1000);
	});
});
</script>