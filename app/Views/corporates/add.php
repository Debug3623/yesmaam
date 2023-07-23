<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<a href="<?= site_url('admin/customer') ?>" class="breadcrumb-item">Corporate</a>
	<span class="breadcrumb-item active">Add Corporate</span>
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
					<b>Add Corporate Details</b>
				</div>
				<div class="card-body">
					<?php if($msg): ?>
						<div class="alert alert-success"><b>Success, </b> <?= $msg ?></div>
					<?php endif; ?>
					<form method="post" action="<?= site_url('admin/corporate/add') ?>" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="first_name">First Name</label>
									<input type="text" name="first_name" id="first_name" class="form-control" value="<?= set_value('first_name') ?>">

									<?php if(isset($validator) && $validator->hasError('first_name')): ?>
									<div class="text-danger"><?= $validator->getError('first_name') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="company_name">Company Name</label>
									<input type="text" name="company_name" id="company_name" class="form-control" value="<?= set_value('company_name') ?>">

									<?php if(isset($validator) && $validator->hasError('company_name')): ?>
									<div class="text-danger"><?= $validator->getError('company_name') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="last_name">Last Name</label>
									<input type="text" name="last_name" id="last_name" class="form-control" value="<?= set_value('last_name') ?>">

									<?php if(isset($validator) && $validator->hasError('last_name')): ?>
									<div class="text-danger"><?= $validator->getError('last_name') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="company_email">Email</label>
									<input type="company_email" name="company_email" id="company_email" class="form-control" value="<?= set_value('company_email') ?>">

									<?php if(isset($validator) && $validator->hasError('company_email')): ?>
									<div class="text-danger"><?= $validator->getError('company_email') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="mobile">Mobile</label>
									<input type="text" name="mobile" id="mobile" class="form-control" value="<?= set_value('mobile') ?>">

									<?php if(isset($validator) && $validator->hasError('mobile')): ?>
									<div class="text-danger"><?= $validator->getError('mobile') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="company_address">Address</label>
									<input type="text" name="company_address" id="company_address" class="form-control" value="<?= set_value('company_address') ?>">

									<?php if(isset($validator) && $validator->hasError('company_address')): ?>
									<div class="text-danger"><?= $validator->getError('company_address') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="city">City</label>
									<input type="text" name="city" id="city" class="form-control" value="<?= set_value('city') ?>">

									<?php if(isset($validator) && $validator->hasError('city')): ?>
									<div class="text-danger"><?= $validator->getError('city') ?></div>
									<?php endif; ?>
								</div>
							</div>
									<div class="col-md-4">
								<div class="form-group">
									<label for="city">about</label>
									<textarea type="text" name="about" id="about" class="form-control"></textarea>

									<?php if(isset($validator) && $validator->hasError('about')): ?>
									<div class="text-danger"><?= $validator->getError('about') ?></div>
									<?php endif; ?>
								</div>
							</div>
					
						</div>

		

						<hr />

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="image">Profile Photo</label>
									<input type="file" name="image" id="image" class="form-control">

									<?php if(isset($validator) && $validator->hasError('image')): ?>
									<div class="text-danger"><?= $validator->getError('image') ?></div>
									<?php endif; ?>
								</div>
							</div>
								<div class="col-md-4">
								<div class="form-group">
									<label for="image">Documents</label>
									<input type="file" name="filename[]" id="filename" class="form-control">

									<?php if(isset($validator) && $validator->hasError('filename')): ?>
									<div class="text-danger"><?= $validator->getError('filename') ?></div>
									<?php endif; ?>
								</div>
							</div>
					
						</div>


						

						<div class="row mt-4">
							<div class="col-md-6">
								<input type="submit" value="Add Corporate" class="btn btn-success" />
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