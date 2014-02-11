<div id="page-wrapper">
<?php
	$this->load->view('wms/wms_header');
?>
	<div class="row">
			<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-tint fa-fw"></i> Ketinggian Air
				</div>
				<div class="panel-body" id="temp-chart">
					
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-tint fa-fw"></i> Kejernihan Air
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