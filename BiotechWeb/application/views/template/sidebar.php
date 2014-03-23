<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li id="dashboard">
				<a href="<?=base_url()?>"><i class="fa fa-dashboard fa-fw"></i> Pratinjau</a>
			</li>
			<li id="dcs">
				<a href="#">
					<i class="fa fa-unlock-alt fa-fw"></i> Sistem Kendali Pintu<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li id="home"><a href="<?=base_url()?>dcs"><i class="fa fa-home fa-fw"></i> Beranda</a></li>
					<li id="user"><a href="<?=base_url()?>dcs/users"><i class="fa fa-users fa-fw"></i> Pengguna</a></li>
					<li id="log"><a href="<?=base_url()?>dcs/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
					<li id="setting"><a href="<?=base_url()?>dcs/setting"><i class="fa fa-wrench fa-fw"></i> Pengaturan</a></li>
				</ul>
			</li>
			<li id="gcs" >
				<a href="#">
					<i class="fa fa-leaf fa-fw"></i>  Sistem Kendali Rumah Kaca<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li id="home"><a href="<?=base_url()?>gcs"><i class="fa fa-home fa-fw"></i> Beranda</a></li>
					<li id="plants"><a href="<?=base_url()?>gcs/plants"><i class="fa fa-leaf fa-fw"></i> Tanaman</a></li>
					<li id="log"><a href="<?=base_url()?>gcs/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
				</ul>
			</li>
			<li id="hcs">
				<a href="#">
					<i class="fa fa-home fa-fw"></i> Sistem Kendali Rumah<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li><a href="<?=base_url()?>hcs"><i class="fa fa-home fa-fw"></i> Beranda</a></li>
					<li><a href="<?=base_url()?>hcs/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
				</ul>
			</li>
			<li id="scs">
				<a href="#">
					<i class="fa fa-cogs fa-fw"></i> Pemantauan Ruang Server<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li><a href="<?=base_url()?>scs"><i class="fa fa-home fa-fw"></i> Beranda</a></li>
					<li><a href="<?=base_url()?>scs/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
					<li><a href="<?=base_url()?>scs/setting"><i class="fa fa-wrench fa-fw"></i> Pengaturan</a></li>
				</ul>
			</li>
			<li id="wms">
				<a href="#">
					<i class="fa fa-tint fa-fw"></i> Pemantauan Ketinggian Air<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li><a href="<?=base_url()?>wms"><i class="fa fa-desktop fa-fw"></i> Beranda</a></li>
					<li><a href="<?=base_url()?>wms/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
					<li><a href="<?=base_url()?>wms/setting"><i class="fa fa-wrench fa-fw"></i> Pengaturan</a></li>
				</ul>
			</li>
		</ul>
		<div class="sidebar sidebar-footer">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="text-left">
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
	</div>
</nav>
<script>
$("#<?=$this->uri->segment(1, 'dashboard')?>").addClass("active");
$("#<?=$this->uri->segment(1, 'dashboard')?>").addClass("selected");
</script>