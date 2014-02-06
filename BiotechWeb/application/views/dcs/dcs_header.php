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
<div id="page-wrapper">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="page-header"><i class="fa fa-<?=$icon?> fa-fw"></i> <?=$header?></h3>
		</div>
	</div>
	<ol class="breadcrumb">
		<li>Condition: </li>
		<li>Password Attempts: </li>
		<li>Status: </li>
	</ol>
</div>