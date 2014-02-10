<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
			<span class="icon-bar"></span> <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.html">Bioteknologi - LIPI</a>
	</div>

	<ul class="nav navbar-top-links navbar-right">
		<li><a href="<?=base_url()?>admin">Admin</a></li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#"> 
				<i class="fa fa-user fa-fw"></i> <?=$this->session->userdata('logged_in')?> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-messages">
				<li><a href="#"><i class="fa fa-gear fa-fw"></i> Ubah Kata Sandi</a></li>
				<li class="divider"></li>
				<li><a href="<?=base_url()?>login/logout"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
			</ul>
		</li>
	</ul>
</nav>