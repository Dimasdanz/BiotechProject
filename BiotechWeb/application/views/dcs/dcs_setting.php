<link href="<?=base_url()?>assets/css/bootstrap-switch.css" rel="stylesheet">
<div id="page-wrapper">
<?php
	$this->load->view('dcs/dcs_header');
?>
	<div class="row">
		<?php 
			if($this->session->flashdata('message')){
		?>
		<div class="col-sm-offset-2">
			<div class="row">
				<div class="col-sm-8">
						<div class="alert alert-<?=$this->session->flashdata('message')[0]?> alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?=$this->session->flashdata('message')[1]?>
						</div>
				    
		    	</div>
			</div>
		</div>
		<?php 
			}
		?>
	</div>
	<div class="row">
		<?php 
			if($condition == 0){
		?>
			<div class="col-sm-offset-2">
				<div class="row">
					<div class="col-sm-4">
						<div class="panel panel-primary">
							<div class="panel-heading" align="center">
								<i class="fa fa-power-off"></i> Device Status
							</div>
							<div class="panel-body" align="center">
								<form class="form-inline" role="form">
									<input type="checkbox" id="status" checked data-on="success" data-off="danger">
								</form>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="panel panel-primary">
							<div class="panel-heading" align="center">
								<i class="fa fa-Keyboard-o"></i> Password Attempts
							</div>
							<div class="panel-body">
								<form class="form-inline" role="form" method="post" action="/dcs/change_attempt">
									<div class="form-group">
										<input type="text" class="form-control" name="password_attempts" value="<?=$password_attempts?>" placeholder="Attempts">
									</div>
									<button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i>&nbsp;</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php 
			}else{
		?>
		<div class="col-sm-offset-2">
			<div class="row">
				<div class="col-sm-8">
					<div class="panel panel-primary">
						<div class="panel-heading" align="center">
							<i class="fa fa-key"></i> Condition
						</div>
						<div class="panel-body">
							<p class="text-danger text-center">Device is locked!</p>
							<a href="/dcs/unlock" class="btn btn-warning btn-block btn-lg"><i class="fa fa-unlock"></i> Unlock</a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<?php 
			}
		?>
	</div>
</div>
<div class="modal fade" id="modal_confirm" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close no" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-left">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p id="confirm_str"></p>
            </div>
            <div class="modal-footer">
            	<?=form_open("/dcs/change_status")?>
	            	<input type="hidden" name="status" id="status_value">
	                <button type="submit" class="btn btn-success" id="yes">Yes</button>
	                <button type="button" class="btn btn-danger no" data-dismiss="modal">No</button>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<?php
	$this->load->view('template/footer');
	$this->load->view('dcs/dcs_footer');
?>
<script src="<?=base_url()?>assets/js/bootstrap-switch.js"></script>
<script>
	$(document).ready(function() {
		$("#status").bootstrapSwitch();
		<?php 
			if($status == 1){
		?>
			$('#status').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#status').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		$('#status').bootstrapSwitch('setOnLabel', 'I');
		$('#status').bootstrapSwitch('setOffLabel', 'O');
		$('#status').on('switch-change', function (e, data) {
			if (data.value == true) {
				$("#status_value").val("on");
				$("#confirm_str").html('Are you sure want to turn on the device?');
			}else{
				$("#status_value").val("off");
				$("#confirm_str").html('Are you sure want to turn off the device?');
			}
			$('#modal_confirm').modal('show');
		});
		$('.no').click(function(){
			$('#status').bootstrapSwitch('toggleState');
		});
	});
</script>