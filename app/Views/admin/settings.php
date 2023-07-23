<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<a href="<?= site_url('admin/customer') ?>" class="breadcrumb-item">Admin</a>
	<span class="breadcrumb-item active">Admin Settings</span>
</div>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content area -->
<div class="content">

	<!-- Main charts -->
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header bg-info text-white">
					<b>Update Store Details</b>
				</div>
				<div class="card-body">
					<?php if($msg): ?>
						<div class="alert alert-success"><b>Success, </b> <?= $msg ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php endif; ?>
					<form method="post" action="<?= site_url('admin/settings') ?>">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="first_name">Store Name</label>
									<input type="text" name="first_name" id="first_name" class="form-control" value="<?= $setting->store_name ?>" />

									<?php if(isset($validator) && $validator->hasError('first_name')): ?>
									<div class="text-danger"><?= $validator->getError('first_name') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="nurse_hour_rate">Nurse Hour Rate</label>
									<input type="text" name="nurse_hour_rate" id="nurse_hour_rate" value="<?= $setting->nurse_hour_rate ?>" class="form-control">

									<?php if(isset($validator) && $validator->hasError('nurse_hour_rate')): ?>
									<div class="text-danger"><?= $validator->getError('nurse_hour_rate') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="nurse_week_rate">Nurse Week Rate</label>
									<input type="text" name="nurse_week_rate" id="nurse_week_rate" value="<?= $setting->nurse_week_rate ?>" class="form-control">

									<?php if(isset($validator) && $validator->hasError('nurse_week_rate')): ?>
									<div class="text-danger"><?= $validator->getError('nurse_week_rate') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="nurse_month_rate">Nurse Month Rate</label>
									<input type="text" name="nurse_month_rate" id="nurse_month_rate" value="<?= $setting->nurse_month_rate ?>" class="form-control">

									<?php if(isset($validator) && $validator->hasError('nurse_month_rate')): ?>
									<div class="text-danger"><?= $validator->getError('nurse_month_rate') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="doctor_hour_rate">Doctor Hour Rate</label>
									<input type="text" name="doctor_hour_rate" id="doctor_hour_rate" value="<?= $setting->doctor_hour_rate ?>" class="form-control">

									<?php if(isset($validator) && $validator->hasError('doctor_hour_rate')): ?>
									<div class="text-danger"><?= $validator->getError('doctor_hour_rate') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="doctor_week_rate">Doctor Doctor Rate</label>
									<input type="text" name="doctor_week_rate" id="doctor_week_rate" value="<?= $setting->doctor_week_rate ?>" class="form-control">

									<?php if(isset($validator) && $validator->hasError('doctor_week_rate')): ?>
									<div class="text-danger"><?= $validator->getError('doctor_week_rate') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="doctor_month_rate">Doctor Month Rate</label>
									<input type="text" name="doctor_month_rate" id="doctor_month_rate" value="<?= $setting->doctor_month_rate ?>" class="form-control">

									<?php if(isset($validator) && $validator->hasError('doctor_month_rate')): ?>
									<div class="text-danger"><?= $validator->getError('doctor_month_rate') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="currency_type">Currency Code</label>
									<input type="text" name="currency_type" id="currency_type" value="<?= $setting->currency_type ?>" class="form-control">

									<?php if(isset($validator) && $validator->hasError('currency_type')): ?>
									<div class="text-danger"><?= $validator->getError('currency_type') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="currency_icon">Currency Icon</label>
									<input type="text" name="currency_icon" id="currency_icon" value="<?= $setting->currency_icon ?>" class="form-control">

									<?php if(isset($validator) && $validator->hasError('currency_icon')): ?>
									<div class="text-danger"><?= $validator->getError('currency_icon') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						

						<div class="row">
							<div class="col-md-6">
								<input type="submit" value="Submit" class="btn btn-success" />
							</div>
						</div>
					</form>
				</div>
			</div>
			

		</div>

	</div>

</div>
<!-- /content area -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
	
$(document).ready(function(){
	$('.table').DataTable();
});
</script>
<?= $this->endSection(); ?>