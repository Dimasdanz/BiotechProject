<div id="page-wrapper">
<?php
	$this->load->view('dcs/dcs_header');
?>
	<div class="col-sm-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-power-off"></i> Device Status
				</div>
				<div class="panel-footer clearfix">
					<a href="#" class="btn btn-success"><i class="fa fa-list"></i> Armed</a>
				</div>
			</div>
		</div>
</div>
<?php
	$this->load->view('template/footer');
	$this->load->view('dcs/dcs_footer');
?>