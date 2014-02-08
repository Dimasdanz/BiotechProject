<?php 
	switch ($this->uri->segment(2)) {
		case 'plants':
			$header = ucfirst($this->uri->segment(2));
			$icon = 'log';
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