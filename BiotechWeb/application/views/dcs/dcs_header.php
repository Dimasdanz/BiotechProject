<?php 
	switch ($this->uri->segment(2)) {
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
		case 'Pengaturan':
			$header = ucfirst($this->uri->segment(2));
			$icon = 'wrench';
			break;
		default:
			$header = 'Beranda';
			$icon = 'home';
		break;
	}
?>

<div class="row">
	<div class="col-sm-12">
		<h3 class="page-header"><i class="fa fa-<?=$icon?> fa-fw"></i> <?=$header?></h3>
	</div>
</div>
	