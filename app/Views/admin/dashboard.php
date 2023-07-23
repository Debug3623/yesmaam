<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">Dashboard</span>
</div>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content area -->
<div class="content">

	<!-- Main charts -->
	<!-- Quick stats boxes -->
	<div class="row">
		<div class="col-lg-4">

			<!-- Members online -->
			<div class="card bg-teal text-white">
				<div class="card-body">
					<div class="d-flex">
						<i class="fa-solid fa-user-doctor" style="font-size: 70px;"></i>
						<h3 class="font-weight-semibold mb-0 ml-2">Total Doctors<br /><?= $n_docs ?></h3>

						<!--
						<span class="badge badge-dark badge-pill align-self-center ml-auto">+53,6%</span>-->
                	</div>
                	
                	<div>
						
					</div>
				</div>

				<div class="container-fluid">
					<div id="members-online"></div>
				</div>
			</div>
			<!-- /members online -->

		</div>

		<div class="col-lg-4">

			<!-- Current server load -->
			<div class="card bg-pink text-white">
				<div class="card-body">
					<div class="d-flex">
						<i class="fa-solid fa-user-nurse" style="font-size: 70px;"></i>
						<h3 class="font-weight-semibold mb-0 ml-2">Total Nurses<br /><?= $n_nurses ?></h3>

						<!--
						<span class="badge badge-dark badge-pill align-self-center ml-auto">+53,6%</span>-->
                	</div>
                	
                	<div>
						
					</div>
				</div>

				<div id="server-load"></div>
			</div>
			<!-- /current server load -->

		</div>

		<div class="col-lg-4">

			<!-- Today's revenue -->
			<div class="card bg-primary text-white">
				<div class="card-body">
					<div class="d-flex">
						<i class="fa-solid fa-users" style="font-size: 70px;"></i>
						<h3 class="font-weight-semibold mb-0 ml-2">Total Customers<br /><?= $n_cus ?></h3>

						<!--
						<span class="badge badge-dark badge-pill align-self-center ml-auto">+53,6%</span>-->
                	</div>
                	
                	<div>
						
					</div>
				</div>

				<div id="today-revenue"></div>
			</div>
			<!-- /today's revenue -->

		</div>
	</div>
	<!-- /quick stats boxes -->

</div>
<!-- /content area -->
<?= $this->endSection(); ?>