<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed" id="dataTables-scs_log">
						<thead>
							<tr>
								<th width="5%">No.</th>
								<th>Temperatur</th>
								<th>Kadar Asap</th>
								<th>Waktu</th>
								<th>Tanggal</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$no = 1;
							if($scs_log != NULL){
								foreach ($scs_log as $row){
						?>
							<tr>
								<td><?=$no?></td>
								<td><?=$row->temperature?></td>
								<td><?=$row->smoke?></td>
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
<script src="<?=base_url()?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function(){
		$('#dataTables-scs_log').dataTable({
			"iDisplayLength": 50,
		<?php 
			if($scs_log != NULL){
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
			"aaSorting": [[ 1, 'asc' ]]
		
		<?php 
			}
		?>
		});
	});
</script>