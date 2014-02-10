<div id="page-wrapper">
<?php
	$this->load->view('wms/wms_header');
?>
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-bar-chart-o"></i> Temperatur
				</div>
				<div class="panel-body" id="temp-chart">
					
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-bar-chart-o"></i> Kadar Asap
				</div>
				<div class="panel-body" id="smoke-chart">
					
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	$this->load->view('template/footer');
?>
<script src="<?=base_url()?>assets/js/plugins/highcharts/highcharts.js"></script>
<script src="<?=base_url()?>assets/js/plugins/highcharts/exporting.js"></script>
<script type="text/javascript">
function requestTemp() {
    $.ajax({
        url: '<?=base_url()?>api/scs_temperature',
        success: function(point) {
            var series = chart.series[0],
                shift = series.data.length > 20;
            chart.series[0].addPoint(point, true, shift);
            setTimeout(requestTemp, 1000);    
        },
        cache: false
    });
}
function requestSmoke() {
    $.ajax({
        url: '<?=base_url()?>api/scs_smoke',
        success: function(point) {
            var series = chart2.series[0],
                shift = series.data.length > 20;
            chart2.series[0].addPoint(point, true, shift);
            setTimeout(requestSmoke, 1000);    
        },
        cache: false
    });
}
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'temp-chart',
			defaultSeriesType: 'spline',
			events: {
				load: requestTemp
			}
		},
		title: {
			text: 'Temperatur'
		},
		xAxis: {
			type: 'datetime',
			tickPixelInterval: 150,
			maxZoom: 20 * 10000
		},
		yAxis: {
			minPadding: 0.2,
			maxPadding: 0.2,
			title: {
				text: 'Nilai (oC)',
				margin: 80
			}
		},
		series: [{
			name: 'Temperatur',
			data: []
		}]
	});

	chart2 = new Highcharts.Chart({
		chart: {
			renderTo: 'smoke-chart',
			defaultSeriesType: 'spline',
			events: {
				load: requestSmoke
			}
		},
		title: {
			text: 'Kadar Asap'
		},
		xAxis: {
			type: 'datetime',
			tickPixelInterval: 150,
			maxZoom: 20 * 10000
		},
		yAxis: {
			minPadding: 0.2,
			maxPadding: 0.2,
			title: {
				text: 'Nilai (ppm)',
				margin: 80
			}
		},
		series: [{
			name: 'Asap',
			data: []
		}]
	});
});
</script>