<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li id="dashboard">
				<a href="<?=base_url()?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
			</li>
			<li id="dcs">
				<a href="#">
					<i class="fa fa-unlock-alt fa-fw"></i> Door Control System<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li id="home"><a href="<?=base_url()?>dcs"><i class="fa fa-home fa-fw"></i> Home</a></li>
					<li id="user"><a href="<?=base_url()?>dcs/users"><i class="fa fa-users fa-fw"></i> Users</a></li>
					<li id="log"><a href="<?=base_url()?>dcs/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
					<li id="setting"><a href="<?=base_url()?>dcs/setting"><i class="fa fa-wrench fa-fw"></i> Setting</a></li>
				</ul>
			</li>
			<li id="gcs">
				<a href="#">
					<i class="fa fa-leaf fa-fw"></i> Greenhouse Control System<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li id="home"><a href="<?=base_url()?>gcs"><i class="fa fa-home fa-fw"></i> Home</a></li>
					<li id="log"><a href="<?=base_url()?>gcs/plants"><i class="fa fa-leaf fa-fw"></i> Plants</a></li>
					<li id="log"><a href="<?=base_url()?>gcs/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
					<li id="setting"><a href="<?=base_url()?>gcs/setting"><i class="fa fa-wrench fa-fw"></i> Setting</a></li>
				</ul>
			</li>
			<li id="hcs">
				<a href="#">
					<i class="fa fa-home fa-fw"></i> Home Control System<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li><a href="<?=base_url()?>hcs"><i class="fa fa-home fa-fw"></i> Home</a></li>
					<li><a href="<?=base_url()?>hcs/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
				</ul>
			</li>
			<li id="scs">
				<a href="#">
					<i class="fa fa-cogs fa-fw"></i> Server Room Control System<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li><a href="<?=base_url()?>scs"><i class="fa fa-home fa-fw"></i> Home</a></li>
					<li><a href="<?=base_url()?>scs/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
					<li><a href="<?=base_url()?>scs/setting"><i class="fa fa-wrench fa-fw"></i> Setting</a></li>
				</ul>
			</li>
			<li id="wms">
				<a href="#">
					<i class="fa fa-tint fa-fw"></i> Water Monitoring System<span class="fa arrow"></span>
				</a>
				<ul class="nav nav-second-level">
					<li><a href="<?=base_url()?>wms"><i class="fa fa-desktop fa-fw"></i> Home</a></li>
					<li><a href="<?=base_url()?>wms/log"><i class="fa fa-list fa-fw"></i> Log</a></li>
					<li><a href="<?=base_url()?>wms/setting"><i class="fa fa-wrench fa-fw"></i> Setting</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>