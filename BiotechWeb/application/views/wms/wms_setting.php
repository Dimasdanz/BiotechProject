<div id="page-wrapper">
<?php
	$this->load->view('wms/wms_header');
?>
	<div class="row">
		<div class="col-sm-12">
			<?php 
				$success = $this->session->flashdata('success');
				$error = $this->session->flashdata('error');
				if($success || $error){
					$text = 'danger';
					$msg = $error;
					if($success){
						$text = 'success';
						$msg = $success;
					}
			?>
			<div class="alert alert-<?=$text?> alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$msg?>
			</div>
			<?php 
				}
			?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					Pengaturan
				</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="post" action="<?=base_url()?>wms/change_water_tank_height">
						<div class="form-group">
							<label class="col-sm-2 control-label">Tinggi Tangki Air</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" placeholder="Tinggi Tangki Air" name="height" value="<?=$height?>">
							</div>
							<p class="help-block">Max = 250cm</p>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	$this->load->view('template/footer');
?>