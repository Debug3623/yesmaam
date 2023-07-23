<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<a href="<?= site_url('admin/customer') ?>" class="breadcrumb-item">Banners</a>
	<span class="breadcrumb-item active">Add Banner</span>
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
					<b>Add Banner Details</b>
				</div>
				<div class="card-body">
					<?php if($msg): ?>
						<div class="alert alert-success"><b>Success, </b> <?= $msg ?></div>
					<?php endif; ?>
					<form method="post" action="<?= site_url('admin/banner/add') ?>" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="image">Image</label>
									<input type="file" name="image" id="image" class="form-control">

									<?php if(isset($validator) && $validator->hasError('image')): ?>
									<div class="text-danger"><?= $validator->getError('image') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="href">Hyperlink</label>
									<input type="text" name="href" id="href" class="form-control">

									<?php if(isset($validator) && $validator->hasError('href')): ?>
									<div class="text-danger"><?= $validator->getError('href') ?></div>
									<?php endif; ?>
								</div>
							</div>

							
						</div>

						

						<div class="row">
							<div class="col-md-6">
								<input type="submit" value="Add Banner" class="btn btn-success" />
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