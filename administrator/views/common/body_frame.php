<div class="body-frame open">
	<aside>
		<nav id="usmenu" class="margin-top-20">
			<a class="end purple" href="<?php echo base_url('admin/dashboard'); ?>"><i class="fas fa-tachometer-alt"></i> Műszerfal</a>
			<div class="end group">
				<a class="olive" href="javascript:void(0);"><i class="fa fa-object-group"></i>Menu group</a>
				<ul>
					<li><a class="olive" href="<?php echo base_url('admin/dashboard/1'); ?>"><i class="fa fa-object-group"></i> Item 1</a></li>
					<li><a class="olive" href="<?php echo base_url('admin/dashboard/2'); ?>"><i class="fa fa-object-group"></i> Item 2</a></li>
				</ul>
			</div>
			<a class="red" href="<?php echo base_url('admin/authentication/sign-out'); ?>"><i class="fa fa-sign-out"></i> Kilépés</a>
		</nav>
	</aside>
	<div class="container-content">
		<div>
			<div class="content"><?php echo $content; ?></div>
		</div>
	</div>
</div>