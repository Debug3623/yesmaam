<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
	<?php
	$uri = service('uri');
	$current = $uri->getSegment(2);
	//die($current);
	?>
	<!-- Sidebar content -->
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-section sidebar-user my-1">
			<div class="sidebar-section-body">
				<div class="media">
					<a href="index.htm#" class="mr-3">
						<img src="<?= site_url('images/logo.jpg') ?>" class="rounded-circle" alt="">
					</a>

					<div class="media-body">
						<div class="font-weight-semibold"><?= session()->get('admin')['name'] ?></div>
						<div class="font-size-sm line-height-sm opacity-50">
							<?= session()->get('admin')['user_type'] ?>
						</div>
					</div>

					<div class="ml-3 align-self-center">
						<button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
							<i class="icon-transmission"></i>
						</button>

						<button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
							<i class="icon-cross2"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->


		<!-- Main navigation -->
		<div class="sidebar-section">
			<ul class="nav nav-sidebar" data-nav-type="accordion">

				<!-- Main -->
				<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
				<li class="nav-item">
					<a href="<?= site_url('admin/dashboard'); ?>" class="nav-link <?= ($current == 'dashboard') ? "active" : ""; ?>">
						<i class="icon-home4"></i>
						<span>
							Dashboard
						</span>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="<?= site_url('admin/category'); ?>" class="nav-link <?= ($current == 'category') ? "active" : ""; ?>">
						<i class="icon-copy mr-3" style="font-size: 18px;"></i>
						<span>
							Categories
						</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?= site_url('admin/customer'); ?>" class="nav-link <?= ($current == 'customer') ? "active" : ""; ?>">
						<i class="fa-solid fa-users mr-3" style="font-size: 18px;"></i>
						<span>
							Customers
						</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?= site_url('admin/nurse'); ?>" class="nav-link <?= ($current == 'nurse') ? "active" : ""; ?>">
						<i class="fa-solid fa-user-nurse mr-3" style="font-size: 18px;">e45e</i>
						<span>
							Nurses
						</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?= site_url('admin/doctor'); ?>" class="nav-link <?= ($current == 'doctor') ? "active" : ""; ?>">
						<i class="fa-solid fa-user-doctor mr-3" style="font-size: 18px;"></i>
						<span>
							Doctors
						</span>
					</a>
				</li>
				
				<!--	<li class="nav-item">-->
				<!--	<a href="<?= site_url('admin/corporate'); ?>" class="nav-link <?= ($current == 'corporate') ? "active" : ""; ?>">-->
				<!--		<i class="fa-solid fa-user-doctor mr-3" style="font-size: 18px;"></i>-->
				<!--		<span>-->
				<!--			Corporate users-->
				<!--		</span>-->
				<!--	</a>-->
				<!--</li>-->
				
						<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="fa-solid fa-clipboard-list mr-3" style="font-size: 18px;"></i> <span>Corporate Users</span></a>

					<ul class="nav nav-group-sub" data-submenu-title="Layouts">
						<li class="nav-item"><a href="<?= site_url('admin/corporate') ?>" class="nav-link">Corporate Plans</a></li>
						<li class="nav-item"><a href="<?= site_url('admin/corporate/employees') ?>" class="nav-link">Employees</a></li>
						<li class="nav-item"><a href="<?= site_url('admin/corporate/billing') ?>" class="nav-link">Billings</a></li>
						
					</ul>
				</li>

				<li class="nav-item">
					<a href="<?= site_url('admin/banner'); ?>" class="nav-link <?= ($current == 'banner') ? "active" : ""; ?>">
						<i class="fa-solid fa-images mr-3" style="font-size: 18px;"></i>
						<span>
							Banners
						</span>
					</a>
				</li>

				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="fa-solid fa-clipboard-list mr-3" style="font-size: 18px;"></i> <span>Bookings</span></a>

					<ul class="nav nav-group-sub" data-submenu-title="Layouts">
						<li class="nav-item"><a href="<?= site_url('admin/booking/doctors') ?>" class="nav-link">Appointments</a></li>
						<li class="nav-item"><a href="<?= site_url('admin/booking/nurses') ?>" class="nav-link">Nurses</a></li>
						<li class="nav-item"><a href="<?= site_url('admin/booking/services') ?>" class="nav-link">Services</a></li>
						
					</ul>
				</li>
				<!--
				<li class="nav-item">
					<a href="<?= site_url('admin/report'); ?>" class="nav-link <?= ($current == 'report') ? "active" : ""; ?>">
						<i class="fa-solid fa-file-lines mr-3" style="font-size: 18px;"></i>
						<span>
							Reports
						</span>
					</a>
				</li>
				-->
			</ul>
		</div>
		<!-- /main navigation -->

	</div>
	<!-- /sidebar content -->
	
</div>
<!-- /main sidebar -->