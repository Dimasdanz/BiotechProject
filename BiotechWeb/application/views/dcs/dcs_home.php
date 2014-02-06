<div id="page-wrapper">
<?php
	$this->load->view('dcs/dcs_header');
?>
	<div class="row">
		<div class="col-sm-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-info-circle"></i> Door Control Status
				</div>
				<ul class="list-group dcs_status">
					<li class="list-group-item clearfix"><div class="pull-left">Status</div><div class="pull-right"><b><?=$status?></b></div></li>
					<li class="list-group-item clearfix"><div class="pull-left">Password Attempts</div><div class="pull-right"><b><?=$password_attempts?></b></div></li>
  					<li class="list-group-item clearfix"><div class="pull-left">Condition</div><div class="pull-right"><b><?=$condition?></b></div></li>
  				</ul>
  				<div class="panel-footer clearfix">
					<a href="#" class="btn btn-primary pull-right"><i class="fa fa-wrench"></i> Change Setting <i class="fa fa-chevron-right"></i></a>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-list"></i> Today's Log
				</div>
					<div class="table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>No.</th>
									<th>Name</th>
									<th>Time</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$no = 1;
								if($today_log != NULL){
									foreach ($today_log as $row){
								?>
									<tr>
										<td><?=$no?></td>
										<td><?=$row->name?></td>
										<td><?=date('h:i:s', strtotime($row->time))?></td>
									</tr>
								<?php 
										$no++;
										}
									}else{
								?>
									<tr>
										<td colspan="3">No Log for today</td>
									</tr>
								<?php 
									}
								?>
							</tbody>
						</table>
					</div>
				<div class="panel-footer clearfix">
					<a href="#" class="btn btn-primary pull-right"><i class="fa fa-list"></i> View Complete Log <i class="fa fa-chevron-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	$this->load->view('template/footer');
	$this->load->view('dcs/dcs_footer');
?>
<script>
	function dcs_status(){
		$('.dcs_status').load('/device_status/dcs');
	}
	setInterval('dcs_status()', 1000);
</script>