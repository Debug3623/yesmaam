<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<a href="<?= site_url('admin/customer') ?>" class="breadcrumb-item">Corporate</a>
	<span class="breadcrumb-item active">Update Corporate</span>
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
					<b>Update Corporate Details</b>
				</div>
				<div class="card-body">
					<?php if($msg): ?>
						<div class="alert alert-success"><b>Success, </b> <?= $msg ?></div>
					<?php elseif(isset($remove_err)): ?>
						<div class="alert alert-danger"><b>Success, </b> <?= $remove_err ?></div>
					<?php endif; ?>
					<form method="post" action="<?= site_url('admin/corporate/employee/update/' . EncryptId($employee->id)) ?>" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="fname">First Name</label>
									<input type="text" name="fname" id="fname" class="form-control" value="<?= $employee->fname ?>">

									<?php if(isset($validator) && $validator->hasError('fname')): ?>
									<div class="text-danger"><?= $validator->getError('fname') ?></div>
									<?php endif; ?>
								</div>
							</div>


							<div class="col-md-4">
								<div class="form-group">
									<label for="lname">Last Name</label>
									<input type="text" name="lname" id="lname" class="form-control" value="<?= $employee->lname ?>">

									<?php if(isset($validator) && $validator->hasError('lname')): ?>
									<div class="text-danger"><?= $validator->getError('lname') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="first_name">Email</label>
									<input type="text" name="email" id="email" class="form-control" value="<?= $user->email ?>">

									<?php if(isset($validator) && $validator->hasError('email')): ?>
									<div class="text-danger"><?= $validator->getError('email') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						
								<div class="row">
				
							<div class="col-md-4">
								<div class="form-group">
									<label for="last_name">Address</label>
									<input type="text" name="address" id="address" class="form-control" value="<?= $employee->address ?>">

									<?php if(isset($validator) && $validator->hasError('address')): ?>
									<div class="text-danger"><?= $validator->getError('address') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="country">Country</label>
									<input type="text" name="country" id="country" class="form-control" value="<?= $employee->country ?>">

									<?php if(isset($validator) && $validator->hasError('country')): ?>
									<div class="text-danger"><?= $validator->getError('country') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="mobile">Mobile</label>
									<input type="text" name="mobile" id="mobile" class="form-control" value="<?= $employee->mobile ?>">

									<?php if(isset($validator) && $validator->hasError('mobile')): ?>
									<div class="text-danger"><?= $validator->getError('mobile') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>


						<div class="row">
						    
						    	<div class="col-md-4">
								<div class="form-group">
									<label for="dob">Date of Birth</label>
									<input type="date" name="dob" id="dob" class="form-control" value="<?= $employee->dob ?>">

									<?php if(isset($validator) && $validator->hasError('dob')): ?>
									<div class="text-danger"><?= $validator->getError('dob') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
							
									<div class="col-md-4">
							    
							
								<div class="form-group">
									<label for="gender">Gender</label>
									<select name="gender" id="gender" class="form-control">
										<option value="">--Select Status--</option>
										<option value="Male" <?= ($employee->gender == 'Male')?"selected":""; ?>>Male</option>
										<option value="Female" <?= ($employee->gender == 'Female')?"selected":""; ?>>Female</option>
									</select>

									<?php if(isset($validator) && $validator->hasError('gender')): ?>
									<div class="text-danger"><?= $validator->getError('gender') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
							   <div class="col-md-4">
								<div class="form-group">
									<label for="mobile">Emirate Id</label>
									<input type="text" name="id_number" id="id_number" class="form-control" value="<?= $employee->id_number ?>">

									<?php if(isset($validator) && $validator->hasError('id_number')): ?>
									<div class="text-danger"><?= $validator->getError('id_number') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
									<div class="col-md-4">
								<div class="form-group">
									<label for="expiry_date">Emirates Expiry</label>
									<input type="date" name="expiry_date" id="expiry_date" class="form-control" value="<?= $employee->expiry_date ?>">

									<?php if(isset($validator) && $validator->hasError('expiry_date')): ?>
									<div class="text-danger"><?= $validator->getError('expiry_date') ?></div>
									<?php endif; ?>
								</div>
							</div>

									<div class="col-md-4">
								<div class="form-group">
									<label for="passport">Passport No</label>
									<input type="text" name="passport" id="passport" class="form-control" value="<?= $employee->passport ?>">

									<?php if(isset($validator) && $validator->hasError('passport')): ?>
									<div class="text-danger"><?= $validator->getError('passport') ?></div>
									<?php endif; ?>
								</div>
							</div>
									
							<div class="col-md-4">
							    
							
								<div class="form-group">
									<label for="visa_status">Visa Status</label>
									<select name="visa_status" id="visa_status" class="form-control">
										<option value="">--Select Status--</option>
										<option value="Resident" <?= ($employee->visa_status == 'Resident')?"selected":""; ?>>Resident</option>
										<option value="Tourist" <?= ($employee->visa_status == 'Tourist')?"selected":""; ?>>Tourist</option>
									</select>

									<?php if(isset($validator) && $validator->hasError('visa_status')): ?>
									<div class="text-danger"><?= $validator->getError('visa_status') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
								<div class="col-md-4">
								<div class="form-group">
									<label for="insurance_status">Insurance Status</label>
									<select name="insurance_status" id="insurance_status" class="form-control">
										<option value="">--Select Status--</option>
										<option value="not available" <?= ($employee->insurance_status == 'not available')?"selected":""; ?>>Not available</option>
										<option value="pending" <?= ($employee->insurance_status == 'pending')?"selected":""; ?>>Pending</option>
										<option value="verified" <?= ($employee->insurance_status == 'verified')?"selected":""; ?>>Verified</option>
										<option value="failed" <?= ($employee->insurance_status == 'failed')?"selected":""; ?>>Failed</option>
									</select>
									

									<?php if(isset($validator) && $validator->hasError('insurance_status')): ?>
									<div class="text-danger"><?= $validator->getError('insurance_status') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="insurance_id">Insurance Company</label>
									<select name="insurance_id" id="insurance_id" class="form-control">
										<option value="">--Select Company--</option>
											<option value="1" <?= ($employee->insurance_id == '1')?"selected":""; ?>>ECARE</option>
										<option value="2" <?= ($employee->insurance_id == '2')?"selected":""; ?>>Nas</option>
										<option value="3" <?= ($employee->insurance_id == '3')?"selected":""; ?>>Neuron</option>
										<option value="4" <?= ($employee->insurance_id == '4')?"selected":""; ?>>Cigna</option>
										<option value="5" <?= ($employee->insurance_id == '5')?"selected":""; ?>>Mednet</option>
										<option value="6" <?= ($employee->insurance_id == '6')?"selected":""; ?>>AXA</option>
										<option value="7" <?= ($employee->insurance_id == '7')?"selected":""; ?>>Daman</option>
										<option value="8" <?= ($employee->insurance_id == '8')?"selected":""; ?>>Oman insurance</option>
										<option value="9" <?= ($employee->insurance_id == '9')?"selected":""; ?>>ADNIC</option>
										<option value="10" <?= ($employee->insurance_id == '10')?"selected":""; ?>>Nextcare(orient is not acceptable)</option>
									</select>

									<?php if(isset($validator) && $validator->hasError('insurance_id')): ?>
									<div class="text-danger"><?= $validator->getError('insurance_id') ?></div>
									<?php endif; ?>
								</div>
							</div>
							

									<div class="col-md-4">
								<div class="form-group">
									<label for="city">City</label>
									<input type="text" name="city" id="city" class="form-control" value="<?= $employee->city ?>">

									<?php if(isset($validator) && $validator->hasError('city')): ?>
									<div class="text-danger"><?= $validator->getError('city') ?></div>
									<?php endif; ?>
								</div>
							</div>
				
							
							<div class="col-md-4">
						
								
									<div class="form-group">
									<label for="emirates_pc">Image</label>
									<input type="file" name="image" id="image" class="form-control">

									<?php if(isset($validator) && $validator->hasError('image')): ?>
									<div class="text-danger"><?= $validator->getError('image') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
						
							
							<div class="col-md-4">
						
								
									<div class="form-group">
									<label for="id_image">Emirate image</label>
									<input type="file" name="id_image" id="id_image" class="form-control">

									<?php if(isset($validator) && $validator->hasError('id_image')): ?>
									<div class="text-danger"><?= $validator->getError('id_image') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
										<div class="col-md-4">
						
								
									<div class="form-group">
									<label for="emirates_pc">Insurance Image</label>
									<input type="file" name="insurance_image" id="insurance_image" class="form-control">

									<?php if(isset($validator) && $validator->hasError('image')): ?>
									<div class="text-danger"><?= $validator->getError('image') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
							<div class="col-md-4">
							    </div>
								<div class="row">
								   
							<div class="col-md-4">
								<?php if($employee->image != ''): ?>
								<img src="<?= site_url($employee->image) ?>" alt="Profile Photo" width="60%" style="display: block; margin: 0 auto;">
								<!--<a href="<?= site_url('admin/employee/remove-file?id=' . EncryptId($employee->id) . '&type=profile&loc=' . urlencode($employee->image)) ?>"><button type="button" class="btn btn-danger btn-block">Remove</button></a>-->
								<!--<?php endif; ?>-->
							</div>
								<div class="col-md-4">
								<?php if($employee->id_image != ''): ?>
								<img src="<?= site_url($employee->id_image) ?>" alt="Profile Photo" width="60%" style="display: block; margin: 0 auto;">
								<!--<a href="<?= site_url('admin/emirateId/remove-file?id=' . EncryptId($employee->id) . '&type=profile&loc=' . urlencode($employee->id_image)) ?>"><button type="button" class="btn btn-danger btn-block">Remove</button></a>-->
								<!--<?php endif; ?>-->
							</div>
							
								<div class="col-md-4">
								<?php if($employee->insurance_image != ''): ?>
								<img src="<?= site_url($employee->insurance_image) ?>" alt="Profile Photo" width="60%" style="display: block; margin: 0 auto;">
								<!--<a href="<?= site_url('admin/insurance/remove-file?id=' . EncryptId($employee->id) . '&type=profile&loc=' . urlencode($employee->insurance_image)) ?>"><button type="button" class="btn btn-danger btn-block">Remove</button></a>-->
								<!--<?php endif; ?>-->
							</div>
							
					
						</div>
					
			
						</div>

						<div class="row">
					
						<div class="row mt-4">
							<div class="col-md-6">
								<input type="submit" value="Update Employee" class="btn btn-success" />
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