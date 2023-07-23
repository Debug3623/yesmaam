<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Yes Maam - Administrator Login</title>

	<!-- Global stylesheets -->
	<link href="<?= site_url('assets/fonts.googleapis.com/css-family=Roboto-400,300,100,500,700,900.htm') ?>" rel="stylesheet" type="text/css">
	<link href="<?= site_url('assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css') ?>">
	<link href="<?= site_url('assets/css/all.min.css') ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?= site_url('assets/js/main/jquery.min.js') ?>"></script>
	<script src="<?= site_url('assets/js/main/bootstrap.bundle.min.js') ?>"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?= site_url('assets/js/app.js') ?>"></script>
	<!-- /theme JS files -->
	<link href="<?= site_url('assets/fontawesome/css/all.min.css') ?>" rel="stylesheet" type="text/css" />

</head>

<body class="bg-secondary">

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Content area -->
				<div class="content d-flex justify-content-center align-items-center">

					<!-- Login card -->
					<form class="login-form" method="post" action="<?= site_url('admin/login') ?>">
						
						<div class="card mb-0">
							<div class="card-body">
								
								<div class="text-center mb-3">
									<img src="<?= site_url('images/yesmaam logo small.png') ?>" height="100px" />
									<h5 class="mb-0">Login to your account</h5>
									<span class="d-block text-muted">Your credentials</span>
								</div>
								<?php if(isset($errors)): ?>
									<?php foreach($errors as $error): ?>
									<div class="alert alert-danger"><?= $error ?></div>
									<?php endforeach; ?>
								<?php endif; ?>
								<div class="form-group form-group-feedback form-group-feedback-left">
									<input type="text" class="form-control" placeholder="Username" name="username" />
									<div class="form-control-feedback">
										<i class="fas fa-user text-muted"></i>
									</div>
								</div>

								<div class="form-group form-group-feedback form-group-feedback-left">
									<input type="password" class="form-control" placeholder="Password" name="password" />
									<div class="form-control-feedback">
										<i class="fa-solid fa-lock text-muted"></i>
									</div>
								</div>

								<div class="form-group d-flex align-items-center">
									<label class="custom-control custom-checkbox">
										<input type="checkbox" name="remember" class="custom-control-input" />
										<span class="custom-control-label">Remember</span>
									</label>

									
								</div>

								
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block">Sign in</button>
								</div>
								
								<span class="form-text text-center text-muted">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
							</div>
						</div>
					</form>
					<!-- /login card -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
	<script src="<?= site_url('assets/fontawesome/js/all.min.js') ?>"></script>
</body>
</html>
