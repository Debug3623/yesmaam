<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<a href="<?= site_url('admin/doctor') ?>" class="breadcrumb-item">Doctors</a>
	<span class="breadcrumb-item active">Update Doctor</span>
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
					<b>Update Doctor Details</b>
				</div>
				<div class="card-body">
					<?php if($msg): ?>
						<div class="alert alert-success"><b>Success, </b> <?= $msg ?></div>
					<?php endif; ?>
					<form method="post" action="<?= site_url('admin/doctor/update/' . EncryptId($doctor->id)) ?>" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="first_name">First Name</label>
									<input type="text" name="first_name" id="first_name" class="form-control" value="<?= $doctor->first_name; ?>">

									<?php if(isset($validator) && $validator->hasError('first_name')): ?>
									<div class="text-danger"><?= $validator->getError('first_name') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="middle_name">Middle Name</label>
									<input type="text" name="middle_name" id="middle_name" class="form-control" value="<?= $doctor->middle_name; ?>">

									<?php if(isset($validator) && $validator->hasError('middle_name')): ?>
									<div class="text-danger"><?= $validator->getError('middle_name') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="last_name">Last Name</label>
									<input type="text" name="last_name" id="last_name" class="form-control" value="<?= $doctor->last_name; ?>">

									<?php if(isset($validator) && $validator->hasError('last_name')): ?>
									<div class="text-danger"><?= $validator->getError('last_name') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" name="email" id="email" class="form-control" value="<?= $doctor->email; ?>">

									<?php if(isset($validator) && $validator->hasError('email')): ?>
									<div class="text-danger"><?= $validator->getError('email') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="mobile">Mobile</label>
									<input type="text" name="mobile" id="mobile" class="form-control"  value="<?= $doctor->mobile; ?>">

									<?php if(isset($validator) && $validator->hasError('mobile')): ?>
									<div class="text-danger"><?= $validator->getError('mobile') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="address">Address</label>
									<input type="text" name="address" id="address" class="form-control" value="<?= $doctor->address; ?>">

									<?php if(isset($validator) && $validator->hasError('address')): ?>
									<div class="text-danger"><?= $validator->getError('address') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="dob">Date of Birth</label>
									<input type="date" name="dob" id="dob" value="<?= $doctor->dob ?>" class="form-control" />

									<?php if(isset($validator) && $validator->hasError('dob')): ?>
									<div class="text-danger"><?= $validator->getError('dob') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="specialities">Specialities</label>
									<input type="text" name="specialities" id="specialities" class="form-control" value="<?= $doctor->specialities ?>">

									<?php if(isset($validator) && $validator->hasError('specialities')): ?>
									<div class="text-danger"><?= $validator->getError('specialities') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="category">Category</label>
									<select name="category" id="category" class="form-control">
										<?php foreach($categories as $cate): ?>
											<option value="<?= $cate->id ?>" <?= ($doctor->category == $cate->id) ? "selected" : ""; ?>><?= $cate->name ?></option>

										<?php endforeach; ?>
									</select>

									<?php if(isset($validator) && $validator->hasError('category')): ?>
									<div class="text-danger"><?= $validator->getError('category') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="speaking_languages">Speaking Languages</label>
									<input type="text" name="speaking_languages" id="speaking_languages" class="form-control" value="<?= $doctor->speaking_languages ?>" />

									<?php if(isset($validator) && $validator->hasError('speaking_languages')): ?>
									<div class="text-danger"><?= $validator->getError('speaking_languages') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="city">City</label>
									<input type="text" name="city" id="city" class="form-control" value="<?= $doctor->city; ?>" />

									<?php if(isset($validator) && $validator->hasError('city')): ?>
									<div class="text-danger"><?= $validator->getError('city') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="photo">Profile Photo</label>

									<?php if(!empty($doctor->photo)): ?>
									<br /><img src="<?= site_url($doctor->photo); ?>" height="140px" style="display:  block; margin: 0 auto;" />
									<?php endif; ?>

									<input type="file" name="photo" id="photo" class="form-control" style="margin-top: 5px;" />

									<?php if(isset($validator) && $validator->hasError('photo')): ?>
									<div class="text-danger"><?= $validator->getError('photo') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="medical_licence">Medical Licence</label>

									<?php if(!empty($doctor->document)): ?>
									<br /><a href="<?= site_url($doctor->document); ?>"><i class="fa-solid fa-id-card" style="font-size: 70px; display: block; margin: 0 auto;"></i></a>
									<?php endif; ?>


									<input type="file" name="medical_licence" id="medical_licence" class="form-control" value="<?= set_value('medical_licence') ?>" />

									<?php if(isset($validator) && $validator->hasError('medical_licence')): ?>
									<div class="text-danger"><?= $validator->getError('medical_licence') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="about_you">About Doctor</label>
									<textarea type="text" name="about_you" id="about_you" class="form-control"><?= $doctor->about_you ?></textarea>

									<?php if(isset($validator) && $validator->hasError('about_you')): ?>
									<div class="text-danger"><?= $validator->getError('about_you') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						

						<div class="row">
							<div class="col-md-6">
								<input type="submit" value="Update Doctor" class="btn btn-danger" />
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
	ClassicEditor
        .create( document.querySelector( '#about_you' ) )
        .catch( error => {
            console.error( error );
    });

	$('.table').DataTable();
});
</script>
<?= $this->endSection(); ?>