<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bioteknologi - LIPI</title>

<!-- CSS -->
<link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?=base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/bootstrap-switch.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/sb-admin.css" rel="stylesheet">

<!-- Javascript -->
<script src="<?=base_url()?>assets/js/jquery-1.10.2.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?=base_url()?>assets/js/sb-admin.js"></script>
<script>
	$(document).ready(function(){
		$("#<?=$this->uri->segment(1, 'dashboard')?>").addClass("selected");
		$("#<?=$this->uri->segment(1, 'dashboard')?>").addClass("active");
	});
</script>

</head>
<body>
	<div id="wrapper">
		<?php 
			if($this->uri->segment(1) != 'login'){ 
				$this->load->view('template/topbar');
				$this->load->view('template/sidebar');
			}
		?>
		<?php
			switch($this->uri->segment(1)){
				case 'admin':
					$header = 'Admin';
					$icon = 'users';
					break;
				default:
					$header = 'Beranda';
					$icon = 'home';
					break;
			}
		
			switch($this->uri->segment(2)){
				case 'users':
					$header = 'Pengguna';
					$icon = 'users';
					break;
				case 'log':
					$header = 'Log';
					$icon = 'list';
					break;
				case 'setting':
					$header = 'Pengaturan';
					$icon = 'wrench';
					break;
				case 'plants':
					$header = "Tanaman";
					$icon = 'leaf';
					break;
				default:
					$header = 'Beranda';
					$icon = 'home';
					break;
			}
			
			switch($this->uri->segment(1)){
				case 'admin':
					$header = 'Admin';
					$icon = 'users';
					break;
			}
			
			if($this->uri->segment(1) != 'login'){
		?>
		<div id="page-wrapper">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="page-header">
						<i class="fa fa-<?=$icon?> fa-fw"></i> <?=$header?></h3>
				</div>
			</div>
			<?php 
				} 
				$this->load->view($content, $contentData)
			?>
		</div>
    </div>
    <!--
	<hr>
	  <div id="footer" class="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="text-left">
						<p class="text-muted credit">
							Pusat Penelitian Bioteknologi - LIPI<br> Jl. Raya Bogor KM 46<br> Cibinong, Kabupaten Bogor<br>Jawa Barat
						</p>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="text-right">
						<p class="text-muted credit">
							Copyright &copy; 2014 <a href="<?=base_url()?>">BiotechSquad</a>
						</p>
						<p class="text-muted credit">
							Created by <a href="http://facebook.com/Dimasdanz" target="_blank">Dimas Rullyan Danu</a>
						</p>
						<p class="text-muted credit small">Powered by SB-Admin</p>
					</div>
				</div>
			</div>
		</div>
	</div> 
	-->
</body>