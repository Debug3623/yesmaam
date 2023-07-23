<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= session()->get('admin')['business_name']; ?> - Admin Panel</title>

	<!-- Global stylesheets -->
	<link href="<?= site_url('assets/') ?>fonts.googleapis.com/css-family=Roboto-400,300,100,500,700,900.htm" rel="stylesheet" type="text/css">
	<link href="<?= site_url('assets/') ?>css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="<?= site_url('assets/') ?>css/all.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?= site_url('assets/') ?>js/main/jquery.min.js"></script>
	<script src="<?= site_url('assets/') ?>js/main/bootstrap.bundle.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?= site_url('assets/') ?>js/plugins/visualization/d3/d3.min.js"></script>
	<script src="<?= site_url('assets/') ?>js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script src="<?= site_url('assets/') ?>js/plugins/ui/moment/moment.min.js"></script>
	<script src="<?= site_url('assets/') ?>js/plugins/pickers/daterangepicker.js"></script>

	<script src="<?= site_url('assets/js/datatables.min.js'); ?>"></script>
	<script src="<?= site_url('assets/') ?>js/app.js"></script>

	<script src="<?= site_url('assets/js/datatables_advanced.js'); ?>"></script>

	<script src="<?= site_url('assets/') ?>js/demo_pages/dashboard.js"></script>
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/streamgraph.js"></script>
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/sparklines.js"></script>
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/lines.js"></script>	
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/areas.js"></script>
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/donuts.js"></script>
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/bars.js"></script>
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/progress.js"></script>
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/heatmaps.js"></script>
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/pies.js"></script>
	<script src="<?= site_url('assets/') ?>js/demo_charts/pages/dashboard/light/bullets.js"></script>
	<!-- /theme JS files -->
	<link href="<?= site_url('assets/fontawesome/css/all.min.css') ?>" rel="stylesheet" type="text/css" />
	<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
</head>

<body>

	<?= $this->include('partials/menubar.php'); ?>


	<!-- Page content -->
	<div class="page-content">

		<?= $this->include('partials/sidebar.php'); ?>


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">
				<!-- Page header -->
<div class="page-header page-header-light">
	<div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
		<div class="d-flex">
			<?= $this->renderSection('bread'); ?>
			

			<a href="<?= site_url('admin/dashboard') ?>" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
		</div>

		
	</div>
</div>
<!-- /page header -->
				

				<?= $this->renderSection('content') ?>


				<?= $this->include('partials/footer.php') ?>

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
<script src="<?= site_url('assets/fontawesome/js/all.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
	<?= $this->renderSection('forms'); ?>
	<?= $this->renderSection('script'); ?>
</body>
</html>
