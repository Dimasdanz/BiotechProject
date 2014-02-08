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
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" id="dataTables-gcs_plants">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th>Name</th>
									<th>Lux Threshold</th>
									<th>Humidity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$no = 1;
								if($gcs_plants != NULL){
									foreach ($gcs_plants as $row){
							?>
								<tr>
									<td><?=$no?></td>
									<td>
										<?=$row->name?>
										<input type="hidden" id="name_<?=$row->plant_id?>" value="<?=$row->name?>">
									</td>
									<td>
										<?=$row->lux?>
										<input type="hidden" id="lux_<?=$row->plant_id?>" value="<?=$row->lux?>">
									</td>
									<td>
										<?=ucfirst($row->humidity)?>
										<input type="hidden" id="humidity_<?=$row->plant_id?>" value="<?=$row->humidity?>">
									</td>
									<td>
										<a href="#" class="btn btn-default edit" data-toggle="modal" data-target="#modal_add" id="<?=$row->plant_id?>">
										<i class="fa fa-edit"></i> Edit</a>
										<a href="#" class="btn btn-danger delete" id="<?=$row->plant_id?>" data-toggle="modal" data-target="#modal_confirm"><i class="fa fa-trash-o"></i> Delete</a>
									</td>
								</tr>
							<?php 
									$no++;
									}
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel-footer clearfix">
					<button class="btn btn-primary pull-right add" data-toggle="modal" data-target="#modal_add">Add New Plant</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form role="form" method="post" action="<?=base_url()?>gcs/insert" id="user_form">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Plant Form</h4>
				</div>
				<div class="modal-body">
					<?php
						if($this->session->flashdata('error')){
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?=$this->session->flashdata('error')?>
					</div>
					<?php
						}
					?>
					<div class="form-group">
						<label>Name</label>
						<input class="form-control" placeholder="Name" type="text" name="name" id="name" required>
						<input type="hidden" name="id" id="id">
					</div>
					<div class="form-group">
						<label>Lux Threshold</label>
						<input class="form-control" placeholder="Lux Threshold" type="text" name="lux" id="lux" required>
						<p class="help-block">Must be numeric</p>
					</div>
					<div class="form-group">
						<select class="form-control" name="humidity" id="humidity" required>
							<option disabled="disabled" selected value="">--Please Select--</option>
							<option value="dry">Dry</option>
							<option value="humid">Humid</option>
							<option value="wet">Wet</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="add">Add New Plant</button>
					<button type="submit" class="btn btn-primary" id="update">Update Plant</button>
				</div>
			</form>
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
            	<?=form_open(base_url()."gcs/delete")?>
	            	<input type="hidden" name="plant_id" id="pid">
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
<script src="<?=base_url()?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function(){
		<?php
			if($this->session->flashdata('error')){
		?>
			$('#modal_add').modal('show');
		<?php
			}
		?>
		$('#dataTables-gcs_plants').dataTable( {
			"fnDrawCallback": function ( oSettings ) {
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
					}
				}
			},
			"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0,4 ] }
			],
			"aaSorting": [[ 1, 'asc' ]]
		});
		
		$('.add').click(function (){
			$('#user_form').attr('action', '<?=base_url()?>gcs/insert');
			$('#add').show();
			$('#update').hide();
			$('#name').val("");
			$('#lux').val("");
		});

		$('.edit').click(function (){
			$('#user_form').attr('action', '<?=base_url()?>gcs/update');
			$('#add').hide();
			$('#update').show();
			$('#id').val(this.id);
			$('#name').val($('#name_'+this.id).val());
			$('#lux').val($('#lux_'+this.id).val());
			$('#humidity').val($('#humidity_'+this.id).val());
		});

		$(".delete").click(function() {
			var name = $('#name_'+this.id).val();
			$("#pid").val(this.id);
			$("#confirm_str").html('Are you sure want to delete <b>'+name+'</b>?');
		});
	});
</script>