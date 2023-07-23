<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<a href="<?= site_url('admin/customer') ?>" class="breadcrumb-item">Nurses</a>
	<span class="breadcrumb-item active">Update Nurse</span>
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
					<b>Update Nurse Details</b>
				</div>
				<div class="card-body">
					<?php if($msg): ?>
						<div class="alert alert-success"><b>Success, </b> <?= $msg ?></div>
					<?php endif; ?>
					<form method="post" action="<?= site_url('admin/nurse/update/' . EncryptId($nurse->id)) ?>" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="first_name">First Name</label>
									<input type="text" name="first_name" id="first_name" class="form-control" value="<?= $nurse->first_name; ?>">

									<?php if(isset($validator) && $validator->hasError('first_name')): ?>
									<div class="text-danger"><?= $validator->getError('first_name') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="middle_name">Middle Name</label>
									<input type="text" name="middle_name" id="middle_name" class="form-control" value="<?= $nurse->middle_name; ?>">

									<?php if(isset($validator) && $validator->hasError('middle_name')): ?>
									<div class="text-danger"><?= $validator->getError('middle_name') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="last_name">Last Name</label>
									<input type="text" name="last_name" id="last_name" class="form-control" value="<?= $nurse->last_name; ?>">

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
									<input type="email" name="email" id="email" class="form-control" value="<?= $nurse->email; ?>">

									<?php if(isset($validator) && $validator->hasError('email')): ?>
									<div class="text-danger"><?= $validator->getError('email') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="mobile">Mobile</label>
									<input type="text" name="mobile" id="mobile" class="form-control" value="<?= $nurse->phone; ?>">

									<?php if(isset($validator) && $validator->hasError('mobile')): ?>
									<div class="text-danger"><?= $validator->getError('mobile') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="address">Address</label>
									<input type="text" name="address" id="address" class="form-control" value="<?= $nurse->address; ?>">

									<?php if(isset($validator) && $validator->hasError('address')): ?>
									<div class="text-danger"><?= $validator->getError('address') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="work_title">Work Title</label>
									<input type="text" name="work_title" id="work_title" value="<?= $nurse->work_title; ?>" class="form-control" />

									<?php if(isset($validator) && $validator->hasError('work_title')): ?>
									<div class="text-danger"><?= $validator->getError('work_title') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="expertise">expertise</label>
									<input type="text" name="expertise" id="expertise" class="form-control" value="<?= $nurse->expertise; ?>">

									<?php if(isset($validator) && $validator->hasError('expertise')): ?>
									<div class="text-danger"><?= $validator->getError('expertise') ?></div>
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
											<option value="<?= $cate->id ?>" <?= ($nurse->category == $cate->id) ? "selected" : ""; ?>><?= $cate->name ?></option>

										<?php endforeach; ?>
									</select>

									<?php if(isset($validator) && $validator->hasError('category')): ?>
									<div class="text-danger"><?= $validator->getError('category') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="working_hours">Working Hours</label>
									<input type="text" name="working_hours" id="working_hours" class="form-control" value="<?= $nurse->working_hours; ?>" />

									<?php if(isset($validator) && $validator->hasError('working_hours')): ?>
									<div class="text-danger"><?= $validator->getError('working_hours') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="date_of_birth">Date of Birth</label>
									<input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="<?= $nurse->date_of_birth; ?>">

									<?php if(isset($validator) && $validator->hasError('date_of_birth')): ?>
									<div class="text-danger"><?= $validator->getError('date_of_birth') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="marital_status">Marital Status</label>
									<select name="marital_status" id="marital_status" class="form-control">
										<?php foreach($statuses as $cate): ?>
											<option value="<?= $cate ?>" <?= ($nurse->marital_status == $cate) ? "selected" : ""; ?>><?= ucfirst($cate); ?></option>

										<?php endforeach; ?>
									</select>

									<?php if(isset($validator) && $validator->hasError('marital_status')): ?>
									<div class="text-danger"><?= $validator->getError('marital_status') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="skills">Skills</label>
									<input type="text" name="skills" id="skills" class="form-control" value="<?= $nurse->skills; ?>" />

									<?php if(isset($validator) && $validator->hasError('skills')): ?>
									<div class="text-danger"><?= $validator->getError('skills') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="visa_type">Visa Type</label>
									<select name="visa_type" id="visa_type" class="form-control">
										<?php foreach($visas as $cate): ?>
											<option value="<?= $cate ?>" <?= ($nurse->visa_type == $cate) ? "selected" : ""; ?>><?= ucfirst($cate); ?></option>

										<?php endforeach; ?>
									</select>

									<?php if(isset($validator) && $validator->hasError('visa_type')): ?>
									<div class="text-danger"><?= $validator->getError('visa_type') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="photo">Profile Photo</label>

									<?php if(!empty($nurse->photo)): ?>
									<br /><img src="<?= site_url($nurse->photo); ?>" height="140px" style="display:  block; margin: 0 auto;" />
									<?php endif; ?>


									<input type="file" name="photo" id="photo" class="form-control" value="<?= set_value('photo') ?>" />

									<?php if(isset($validator) && $validator->hasError('photo')): ?>
									<div class="text-danger"><?= $validator->getError('photo') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="working_type">Work Types</label>
									<select name="working_type" id="working_type" class="form-control">
										<?php foreach($work_types as $cate): ?>
											<option value="<?= $cate ?>" <?= ($nurse->working_type == $cate) ? "selected" : ""; ?>><?= ucfirst($cate); ?></option>

										<?php endforeach; ?>
									</select>

									<?php if(isset($validator) && $validator->hasError('working_type')): ?>
									<div class="text-danger"><?= $validator->getError('working_type') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="city">City</label>
									<input type="text" name="city" id="city" class="form-control" value="<?= $nurse->city ?>" />

									<?php if(isset($validator) && $validator->hasError('city')): ?>
									<div class="text-danger"><?= $validator->getError('city') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" name="password" id="password" class="form-control" value="<?= set_value('password') ?>" />

									<?php if(isset($validator) && $validator->hasError('password')): ?>
									<div class="text-danger"><?= $validator->getError('password') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="experience">Experience</label>
									<input type="number" name="experience" id="experience" class="form-control" value="<?= $nurse->experience; ?>" />

									<?php if(isset($validator) && $validator->hasError('experience')): ?>
									<div class="text-danger"><?= $validator->getError('experience') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="nationality">Nationality</label>
									<input type="text" name="nationality" id="nationality" class="form-control" value="<?= $nurse->nationality ?>" />

									<?php if(isset($validator) && $validator->hasError('nationality')): ?>
									<div class="text-danger"><?= $validator->getError('nationality') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
                      
                      <div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="eid">EID no</label>
									<input type="text" name="eid" id="eid" class="form-control" value="<?= $nurse->EID; ?>" />

									<?php if(isset($validator) && $validator->hasError('eid')): ?>
									<div class="text-danger"><?= $validator->getError('eid') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="passport_no">Passport No</label>
									<input type="text" name="passport_no" id="passport_no" class="form-control" value="<?= $nurse->passport_no ?>" />

									<?php if(isset($validator) && $validator->hasError('passport_no')): ?>
									<div class="text-danger"><?= $validator->getError('passport_no') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="passport">Pasport Photo Copy - <?php if(!empty($nurse->passport)){ ?><a href="<?= site_url($nurse->passport) ?>" target="_blank">Uploaded</a><?php } ?></label>
									<input type="file" name="passport" id="passport" class="form-control" />

									<?php if(isset($validator) && $validator->hasError('passport')): ?>
									<div class="text-danger"><?= $validator->getError('passport') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="about">About Nurse</label>
									<textarea type="text" name="about" id="about" class="form-control"><?= $nurse->about; ?></textarea>

									<?php if(isset($validator) && $validator->hasError('about')): ?>
									<div class="text-danger"><?= $validator->getError('about') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						

						<div class="row">
							<div class="col-md-6">
								<input type="submit" value="Update Nurse" class="btn btn-success" />
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
        .create( document.querySelector( '#about' ) )
        .catch( error => {
            console.error( error );
    });

	$('.table').DataTable();
});
</script>
<?= $this->endSection(); ?>