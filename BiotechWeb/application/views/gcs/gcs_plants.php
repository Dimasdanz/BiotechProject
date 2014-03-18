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
									<th>Nama</th>
									<th>Ambang Batas Intensitas Cahaya</th>
									<th>Kelembaban</th>
									<th>Aksi</th>
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
										<a href="#" class="btn btn-default edit" data-toggle="modal" data-target="#modal_add" id="edit_<?=$row->plant_id?>"><i class="fa fa-edit"></i> Ubah</a>
										<a href="#" class="btn btn-danger delete" id="delete_<?=$row->plant_id?>" data-toggle="modal" data-target="#modal_confirm"><i class="fa fa-trash-o"></i> Hapus</a>
										<a href="#" class="btn btn-primary select" id="select_<?=$row->plant_id?>" data-toggle="modal" data-target="#modal_confirm"><i class="fa fa-check"></i> Pilih</a>
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
					<button class="btn btn-primary pull-right add" data-toggle="modal" data-target="#modal_add">Tambah Tanaman Baru</button>
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
						<h4 class="modal-title" id="myModalLabel">Form Tanaman</h4>
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
						<label>Nama</label>
						<input class="form-control" placeholder="Nama" type="text" name="name" id="name" required>
						<input type="hidden" name="id" id="id">
					</div>
					<div class="form-group">
						<label>Ambang Batas Intesitas Cahaya</label>
						<input class="form-control" placeholder="Ambang Batas Intesitas Cahay" type="text" name="lux" id="lux" required>
						<p class="help-block">Harus berupa angka</p>
					</div>
					<div class="form-group">
						<select class="form-control" name="humidity" id="humidity" required>
							<option disabled="disabled" selected value="">--Pilih--</option>
							<option value="dry">Kering</option>
							<option value="humid">Lembab</option>
							<option value="wet">Basah</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary" id="add">Tambah Tanaman Baru</button>
					<button type="submit" class="btn btn-primary" id="update">Perbaharui Tanaman</button>
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
                <h4 class="modal-title text-left">Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <p id="confirm_str"></p>
            </div>
            <div class="modal-footer">
            	<form role="form" method="post" id="confirm_form">
	            	<input type="hidden" name="plant_id" id="pid">
	                <button type="submit" class="btn btn-success" id="yes">Ya</button>
	                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                </form>
            </div>
        </div>
    </div>
<script src="<?=base_url()?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function(){
		$('#select_<?=$selected_plant->plant_id?>').attr('disabled', 'disabled');
		$('#select_<?=$selected_plant->plant_id?>').html('Selected');
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
			"oLanguage": {
				"sLengthMenu": "Tampilkan _MENU_ data per halaman",
				"sInfo": "Menampilkan _START_ ke _END_ dari _TOTAL_ records",
				"sInfoEmpty": "Menampilkan 0 ke 0 dari 0 baris",
				"sZeroRecords": "Belum ada data",
				"sSearch": "Pencarian",
				"oPaginate" : {
					"sNext" : "Berikut",
					"sPrevious" : "Sebelum",
					"sFirst": "Halaman Pertama",
					"sLast": "Halaman Terakhir",
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
			var edit_id = this.id.substr(5);
			$('#user_form').attr('action', '<?=base_url()?>gcs/update');
			$('#add').hide();
			$('#update').show();
			$('#id').val(edit_id);
			$('#name').val($('#name_'+edit_id).val());
			$('#lux').val($('#lux_'+edit_id).val());
			$('#humidity').val($('#humidity_'+edit_id).val());
		});

		$(".delete").click(function() {
			var delete_id = this.id.substr(7);
			var name = $('#name_'+delete_id).val();
			$("#pid").val(delete_id);
			$('#confirm_form').attr('action', '<?=base_url()?>gcs/delete');
			$("#confirm_str").html('Are you sure want to delete <b>'+name+'</b>?');
		});

		$(".select").click(function() {
			var select_id = this.id.substr(7);
			var name = $('#name_'+select_id).val();
			$("#pid").val(select_id);
			$('#confirm_form').attr('action', '<?=base_url()?>gcs/select');
			$("#confirm_str").html('Are you sure want to select <b>'+name+'</b>?');
		});
	});
</script>