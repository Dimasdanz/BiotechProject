<div id="page-wrapper">
<?php
	$this->load->view('wms/wms_header');
?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed" id="dataTables-wms_log">
							<thead>
								<tr>
									<th width="5%">No.</th>
									<th>Ketinggian Air</th>
									<th>Kejernihan Air</th>
									<th>Waktu</th>
									<th>Tanggal</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$no = 1;
								if($wms_log != NULL){
									foreach ($wms_log as $row){
							?>
								<tr>
									<td><?=$no?></td>
									<td><?=$row->water_level?></td>
									<td><?=$row->turbidity?></td>
									<td><?=date('h:i:s', strtotime($row->time))?></td>
									<td><?=date('d F Y', strtotime($row->time))?></td>
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
		$('#dataTables-wms_log').dataTable({
			"iDisplayLength": 50,
		<?php 
			if($wms_log != NULL){
		?>
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
				{ "bSortable": false, "aTargets": [ 0 ] }
			],
			"aaSorting": [[ 4, 'desc' ]]		
		<?php 
			}
		?>
		});
	});
</script>