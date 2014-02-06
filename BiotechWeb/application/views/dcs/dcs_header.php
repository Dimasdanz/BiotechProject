<?php 
	switch ($this->uri->segment(2)) {
		case 'users':
			$header = ucfirst($this->uri->segment(2));
			$icon = 'users';
		break;
		case 'log':
			$header = ucfirst($this->uri->segment(2));
			$icon = 'list';
			break;
		case 'setting':
			$header = ucfirst($this->uri->segment(2));
			$icon = 'wrench';
			break;
		default:
			$header = 'Home';
			$icon = 'home';
		break;
	}
?>

	<div class="row">
		<div class="col-sm-12">
			<h3 class="page-header"><i class="fa fa-<?=$icon?> fa-fw"></i> <?=$header?></h3>
		</div>
	</div>
	<div class="device_status">
		<ol class="breadcrumb">
			<li>Condition: n/a</li>
			<li>Password Attempts: n/a</li>
			<li>Status: n/a</li>
		</ol>
	</div>