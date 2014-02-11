<div id="page-wrapper">
	<div class="row">
		<div class="col-sm-12">
			<h1 class="page-header">Pratinjau</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="fa fa-unlock-alt"></i> Sistem Kendali Pintu
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th>No.</th>
											<th>Nama</th>
											<th>Waktu</th>
										</tr>
									</thead>
									<tbody>
                                        <tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="fa fa-home fa-fw"></i> Sistem Kendali Rumah
						</div>
						<div class="panel-body text-center">
							<div class="row">
								<div class="col-sm-3">
									<h5>Lampu 1</h5>
									<h2>ON</h2>
								</div>
								<div class="col-sm-3">
									<h5>Lampu 2</h5>
									<h2>OFF</h2>
								</div>
								<div class="col-sm-3">
									<h5>Lampu 3</h5>
									<h2>OFF</h2>
								</div>
								<div class="col-sm-3">
									<h5>Lampu 4</h5>
									<h2>ON</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<i class="fa fa-tint fa-fw"></i> Pemantauan Air
								</div>
								<div class="panel-body text-center">
									<div class="row">
										<div class="col-sm-6">
											<h5>Tinggi Air</h5>
											<h2>120 CM</h2>
										</div>
										<div class="col-sm-6">
											<h5>Turbiditas</h5>
											<h2>0%</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<i class="fa fa-cogs fa-fw"></i> Ruang Server
								</div>
								<div class="panel-body text-center">
									<div class="row">
										<div class="col-sm-6">
											<h5>Temperatur</h5>
                                    		<?php if($last_log != NULL) {?>
											<h2><?= $last_log->temperature?> &deg;C</h2>
                                    		<?php } else echo "<h2>Tidak Ada Data</h2>";?>
											<h2 class="text-success"><strong><?=$temp_indicator;?></strong></h2>                      
										</div>
										<div class="col-sm-6">
											<h5>Kadar Asap</h5>
                                            <?php if($last_log != NULL) {?>
											<h2><?= $last_log->smoke?> ppm</h2>
                                            <?php } else echo "<h2>Tidak Ada Data</h2>";?>
                                            <h2 class="text-success"><strong><?=$smoke_indicator;?></strong></h2>                      
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="fa fa-leaf"></i> Rumah Kaca
						</div>
						
                        <div class="panel-body text-center">
							<h4>Tanaman : Anggrek</h4>
							<div class="row">
								<div class="col-sm-4">
									<h5>Intensitas Cahaya</h5>
									<h2>6000 lx</h2>
								</div>
								<div class="col-sm-4">
									<h5>Kelembaban</h5>
									<h2>Lembab</h2>
								</div>
								<div class="col-sm-4">
									<h5>Temperatur</h5>
									<h2>32&deg;C</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	$this->load->view('template/footer');
?>