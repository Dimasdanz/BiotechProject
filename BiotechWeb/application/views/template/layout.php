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
</body>