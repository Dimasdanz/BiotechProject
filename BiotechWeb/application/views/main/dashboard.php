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
									<tbody id="dcs_log_table">
									
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
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="fa fa-tint fa-fw"></i> Pemantauan Air
						</div>
						<div class="panel-body text-center">
							<div class="row">
								<div class="col-sm-6">
									<h5>Tinggi Air</h5>
									<h2 id="wms_water_level">n/a</h2>
								</div>
								<div class="col-sm-6">
									<h5>Turbiditas</h5>
									<h2 id="wms_turbidity">n/a</h2>
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
							<i class="fa fa-cogs fa-fw"></i> Ruang Server
						</div>
						<div class="panel-body text-center">
							<div class="row">
								<div class="col-sm-6">
									<h5>Temperatur</h5>
									<h2 id="scs_temp_value">n/a</h2>
									<h2 id="scs_temp_status"></h2>                      
								</div>
								<div class="col-sm-6">
									<h5>Kadar Asap</h5>
									<h2 id="scs_smoke_value">n/a</h2>
									<h2 id="scs_smoke_status"></h2>                      
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
<script>
$(document).ready(function(){
	function requestScsSmoke() {
	    $.ajax({
	        url: '<?=base_url()?>api/scs_smoke',
	        success: function(point) {
		        var ppm = point[1];
		        $("#scs_smoke_value").html(ppm+" ppm");
		        if(ppm >= 100 && ppm <= 350){
			        $("#scs_smoke_status").addClass("text-success");
		        	$("#scs_smoke_status").html("<strong>Baik<strong>");
			    }else if(ppm >= 351 && ppm <= 450){
			    	$("#scs_smoke_status").addClass("text-warning");
			    	$("#scs_smoke_status").html("<strong>Normal<strong>");
			    }else if(ppm >= 451 && ppm <= 600){
			    	$("#scs_smoke_status").addClass("text-warning");
			    	$("#scs_smoke_status").html("<strong>Rata-rata<strong>");
				}else if(ppm >= 600) {
					$("#scs_smoke_status").addClass("text-danger");
			    	$("#scs_smoke_status").html("<strong>Bahaya<strong>");
				}
	            setTimeout(requestScsSmoke, 1000);   
	        },
	        cache: false
	    });
	}
	requestScsSmoke();
	function requestScsTemp() {
	    $.ajax({
	        url: '<?=base_url()?>api/scs_temperature',
	        success: function(points) {
		        var temp = points[1];
		        $("#scs_temp_value").html(temp+" &deg;C");
		        if(temp >= 20 && temp <= 24){
			        $("#scs_temp_status").addClass("text-success");
		        	$("#scs_temp_status").html("<strong>Baik<strong>");
			    }else if(temp >= 25 && temp <= 35){
			    	$("#scs_temp_status").addClass("text-warning");
			    	$("#scs_temp_status").html("<strong>Normal<strong>");
			    }else if(temp >= 35){
			    	$("#scs_temp_status").addClass("text-danger");
			    	$("#scs_temp_status").html("<strong>Bahaya<strong>");
				}else{

				}
	            setTimeout(requestScsTemp, 1000);   
	        },
	        cache: false
	    });
	}
	requestScsTemp();
	function getWmsValue(){
		$.ajax({
	        url: '<?=base_url()?>api/wms_realtime_value',
	        success: function(points) {
		        var water_level = points[1],
		        	lux = points[0];
		        $("#wms_water_level").html(water_level+" cm");
		        $("#wms_turbidity").html(lux+"%");
		        
	            setTimeout(getWmsValue, 1000);
	        },
	        cache: false
	    });
	}
	getWmsValue();
	function getDcsLog(){
		$("#dcs_log_table").load('<?=base_url()?>api/dcs_today_log');
		setTimeout(getDcsLog, 1000);
	}
	getDcsLog();
});
</script>