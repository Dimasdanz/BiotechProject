<div id="page-wrapper">
<?php
	$this->load->view('gcs/gcs_header');
?>
	<?php 
		if($this->session->flashdata('success')){
	?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?=$this->session->flashdata('success')?>
		</div>
    <?php 
    	}
    ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-lightbulb-o"></i> Lamp Condition
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3 text-center">
							<h4>Lamp 1</h4>
							<input type="checkbox" id="lamp_1" checked data-on="success" data-off="danger">
						</div>
						<div class="col-sm-3 text-center">
							<h4>Lamp 2</h4>
							<input type="checkbox" id="lamp_2" checked data-on="success" data-off="danger">
						</div>
						<div class="col-sm-3 text-center">
							<h4>Lamp 3</h4>
							<input type="checkbox" id="lamp_3" checked data-on="success" data-off="danger">
						</div>
						<div class="col-sm-3 text-center">
							<h4>Lamp 4</h4>
							<input type="checkbox" id="lamp_4" checked data-on="success" data-off="danger">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_confirm" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-left">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p id="confirm_str"></p>
            </div>
            <div class="modal-footer">
            	<?=form_open(base_url().'hcs/change_status')?>
            		<input type="hidden" name="lamp" id="lid">
					<input type="hidden" name="status" id="status_value">
					<button type="submit" class="btn btn-success" id="yes">Yes</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<?php
	$this->load->view('template/footer');
?>
<script src="<?=base_url()?>assets/js/bootstrap-switch.js"></script>
<script>
	$(document).ready(function() {
		<?php 
			if($lamp_1 == 1){
		?>
			$('#lamp_1').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#lamp_1').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		<?php 
			if($lamp_2 == 1){
		?>
			$('#lamp_2').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#lamp_2').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		<?php 
			if($lamp_3 == 1){
		?>
			$('#lamp_3').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#lamp_3').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		<?php 
			if($lamp_4 == 1){
		?>
			$('#lamp_4').bootstrapSwitch('setState', true);
		<?php 
			}else{
		?>
			$('#lamp_4').bootstrapSwitch('setState', false);
		<?php 
			}
		?>
		$("input[id^=lamp]").bootstrapSwitch();
		$("input[id^=lamp]").on('switch-change', function (e, data) {
			if (data.value == true) {
				var name = this.id;
				var string = name.charAt(0).toUpperCase() + name.slice(1);
				$("#lid").val(this.id);
				$("#status_value").val(1);
				$("#confirm_str").html('Are you sure want to turn on '+string.replace(/_/g, ' ')+'?');
			}else{
				var name = this.id;
				var string = name.charAt(0).toUpperCase() + name.slice(1);
				$("#lid").val(this.id);
				$("#status_value").val(0);
				$("#confirm_str").html('Are you sure want to turn off '+string.replace(/_/g, ' ')+'?');
			}
			$('#modal_confirm').modal('show');
		});
		$('#modal_confirm').on('hide.bs.modal', function (e) {
			$("#"+$("#lid").val()).bootstrapSwitch('toggleState');
		});
	});
</script>