<div id="page-wrapper">
<?php
	$this->load->view('dcs/dcs_header');
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
						<table class="table table-hover table-condensed" id="dataTables-dcs_user">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th>Name</th>
									<th>ID</th>
									<th>Password</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$no = 1;
								if($dcs_users != NULL){
									foreach ($dcs_users as $row){
							?>
								<tr>
									<td><?=$no?></td>
									<td>
										<?=$row->name?>
										<input type="hidden" id="name_<?=$row->user_id?>" value="<?=$row->name?>">
									</td>
									<td><?=$row->user_id?></td>
									<td>
										<?=$row->password?>
										<input type="hidden" id="password_<?=$row->user_id?>" value="<?=$row->password?>">
									</td>
									<td>
										<a href="#" class="btn btn-default edit" data-toggle="modal" data-target="#modal_add" id="<?=$row->user_id?>">
										<i class="fa fa-edit"></i> Edit</a>
										<a href="#" class="btn btn-danger delete" id="<?=$row->user_id?>" data-toggle="modal" data-target="#modal_confirm"><i class="fa fa-trash-o"></i> Delete</a>
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
					<button class="btn btn-primary pull-right add" data-toggle="modal" data-target="#modal_add">Add New User</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form role="form" method="post" action="/dcs/insert" id="user_form">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">User Form</h4>
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
						<label>ID</label>
						<input class="form-control" placeholder="ID" type="text" name="id" id="id" value="<?=$user_id?>" readonly>
					</div>
					<div class="form-group">
						<label>Name</label>
						<input class="form-control" placeholder="Name" type="text" name="name" id="name" required>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input class="form-control" placeholder="Password" type="text" name="password" id="password" required>
						<p class="help-block">Must be numeric 0-9</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="add">Add New User</button>
					<button type="submit" class="btn btn-primary" id="update">Update User</button>
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
            	<?=form_open("/dcs/delete")?>
	            	<input type="hidden" name="user_id" id="user_id">
	                <button type="submit" class="btn btn-success" id="yes">Yes</button>
	                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<?php
	$this->load->view('template/footer');
	$this->load->view('dcs/dcs_footer');
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
		$('#dataTables-dcs_user').dataTable( {
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
				{ "bSortable": false, "aTargets": [ 0,3,4 ] }
			],
			"aaSorting": [[ 2, 'asc' ]]
		});

		$('.add').click(function (){
			$('#user_form').attr('action', '/dcs/insert');
			$('#add').show();
			$('#update').hide();
			$('#id').val("<?=$user_id?>");
			$('#name').val("");
			$('#password').val("");
		});

		$('.edit').click(function (){
			$('#user_form').attr('action', '/dcs/update');
			$('#add').hide();
			$('#update').show();
			$('#id').val(this.id);
			$('#name').val($('#name_'+this.id).val());
			$('#password').val($('#password_'+this.id).val());
		});

		$(".delete").click(function() {
			var name = $('#name_'+this.id).val();
			$("#user_id").val(this.id);
			$("#confirm_str").html('Are you sure want to delete <b>'+name+'</b>?');
		});
	});
</script>