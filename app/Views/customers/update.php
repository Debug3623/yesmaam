<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<a href="<?= site_url('admin/customer') ?>" class="breadcrumb-item">Customers</a>
	<span class="breadcrumb-item active">Update Customer</span>
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
					<b>Update Customer Details</b>
				</div>
				<div class="card-body">
					<?php if($msg): ?>
						<div class="alert alert-success"><b>Success, </b> <?= $msg ?></div>
					<?php elseif(isset($remove_err)): ?>
						<div class="alert alert-danger"><b>Success, </b> <?= $remove_err ?></div>
					<?php endif; ?>
					<form method="post" action="<?= site_url('admin/customer/update/' . EncryptId($customer->id)) ?>" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="first_name">First Name</label>
									<input type="text" name="first_name" id="first_name" class="form-control" value="<?= $customer->first_name ?>">

									<?php if(isset($validator) && $validator->hasError('first_name')): ?>
									<div class="text-danger"><?= $validator->getError('first_name') ?></div>
									<?php endif; ?>
								</div>
							</div>

							<!-- <div class="col-md-4">
								<div class="form-group">
									<label for="middle_name">Middle Name</label>
									<input type="text" name="middle_name" id="middle_name" class="form-control" value="<?= $customer->middle_name ?>">

									<?php if(isset($validator) && $validator->hasError('middle_name')): ?>
									<div class="text-danger"><?= $validator->getError('middle_name') ?></div>
									<?php endif; ?>
								</div>
							</div> -->

							<div class="col-md-4">
								<div class="form-group">
									<label for="last_name">Last Name</label>
									<input type="text" name="last_name" id="last_name" class="form-control" value="<?= $customer->last_name ?>">

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
									<input type="email" name="email" id="email" class="form-control" value="<?= $customer->email ?>">

									<?php if(isset($validator) && $validator->hasError('email')): ?>
									<div class="text-danger"><?= $validator->getError('email') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="mobile">Mobile</label>
									<input type="text" name="mobile" id="mobile" class="form-control" value="<?= $customer->mobile ?>">

									<?php if(isset($validator) && $validator->hasError('mobile')): ?>
									<div class="text-danger"><?= $validator->getError('mobile') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="address">Address</label>
									<input type="text" name="address" id="address" class="form-control" value="<?= $customer->address ?>">

									<?php if(isset($validator) && $validator->hasError('address')): ?>
									<div class="text-danger"><?= $validator->getError('address') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="city">City</label>
									<input type="text" name="city" id="city" class="form-control" value="<?= $customer->city ?>">

									<?php if(isset($validator) && $validator->hasError('city')): ?>
									<div class="text-danger"><?= $validator->getError('city') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="passport_no">Passport No</label>
									<input type="text" name="passport_no" id="passport_no" class="form-control" value="<?= $customer->passport_no ?>">

									<?php if(isset($validator) && $validator->hasError('passport_no')): ?>
									<div class="text-danger"><?= $validator->getError('passport_no') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="dob">Date of Birth</label>
									<input type="date" name="dob" id="dob" class="form-control" value="<?= $customer->dob ?>">

									<?php if(isset($validator) && $validator->hasError('dob')): ?>
									<div class="text-danger"><?= $validator->getError('dob') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="visa_status">Visa Status</label>
									<select name="visa_status" id="visa_status" class="form-control">
										<option value="">--Select Status--</option>
										<option value="resident" <?= ($customer->visa_status == 'resident')?"selected":""; ?>>Resident</option>
										<option value="tourist" <?= ($customer->visa_status == 'tourist')?"selected":""; ?>>Tourist</option>
									</select>

									<?php if(isset($validator) && $validator->hasError('visa_status')): ?>
									<div class="text-danger"><?= $validator->getError('visa_status') ?></div>
									<?php endif; ?>
								</div>
							</div>
							
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="emirates_id">Emirates ID</label>
									<input type="text" name="emirates_id" id="emirates_id" class="form-control" value="<?= $customer->emirates_id ?>">

									<?php if(isset($validator) && $validator->hasError('emirates_id')): ?>
									<div class="text-danger"><?= $validator->getError('emirates_id') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="emirates_status">Emirates Status</label>
									<select name="emirates_status" id="emirates_status" class="form-control">
										<option value="">--Select Status--</option>
										<option value="not available" <?= ($customer->emirates_status == 'not available')?"selected":""; ?>>Not Available</option>
										<option value="pending" <?= ($customer->emirates_status == 'pending')?"selected":""; ?>>Pending</option>
										<option value="verified" <?= ($customer->emirates_status == 'verified')?"selected":""; ?>>Verified</option>
										<option value="failed" <?= ($customer->emirates_status == 'failed')?"selected":""; ?>>Failed</option>
									</select>

									<?php if(isset($validator) && $validator->hasError('emirates_status')): ?>
									<div class="text-danger"><?= $validator->getError('emirates_status') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="emirates_expiry">Emirates Expiry</label>
									<input type="date" name="emirates_expiry" id="emirates_expiry" class="form-control" value="<?= $customer->emirates_expiry ?>">

									<?php if(isset($validator) && $validator->hasError('emirates_expiry')): ?>
									<div class="text-danger"><?= $validator->getError('emirates_expiry') ?></div>
									<?php endif; ?>
								</div>
							</div>


							
							
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="insurance_id">Insurance Id</label>
									<input type="text" name="insurance_id" id="insurance_id" class="form-control" value="<?= $customer->insurance_id ?>">

									<?php if(isset($validator) && $validator->hasError('insurance_id')): ?>
									<div class="text-danger"><?= $validator->getError('insurance_id') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="insurance_status">Insurance Status</label>
									<select name="insurance_status" id="insurance_status" class="form-control">
										<option value="">--Select Status--</option>
										<option value="not available" <?= ($customer->insurance_status == 'not available')?"selected":""; ?>>Not Available</option>
										<option value="pending" <?= ($customer->insurance_status == 'pending')?"selected":""; ?>>Pending</option>
										<option value="verified" <?= ($customer->insurance_status == 'verified')?"selected":""; ?>>Verified</option>
										<option value="failed" <?= ($customer->insurance_status == 'failed')?"selected":""; ?>>Failed</option>
									</select>

									<?php if(isset($validator) && $validator->hasError('insurance_status')): ?>
									<div class="text-danger"><?= $validator->getError('insurance_status') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="insurance_company">Insurance Company</label>
									<select name="insurance_company" id="insurance_company" class="form-control">
										<option value="">--Select Company--</option>
										<option value="Nas" <?= ($customer->insurance_company == 'Nas')?"selected":""; ?>>Nas</option>
										<option value="Neuron" <?= ($customer->insurance_company == 'Neuron')?"selected":""; ?>>Neuron</option>
										<option value="Cigna" <?= ($customer->insurance_company == 'Cigna')?"selected":""; ?>>Cigna</option>
										<option value="Mednet" <?= ($customer->insurance_company == 'Mednet')?"selected":""; ?>>Mednet</option>
										<option value="AXA" <?= ($customer->insurance_company == 'AXA')?"selected":""; ?>>AXA</option>
										<option value="Daman" <?= ($customer->insurance_company == 'Daman')?"selected":""; ?>>Daman</option>
										<option value="Oman insurance" <?= ($customer->insurance_company == 'Oman insurance')?"selected":""; ?>>Oman insurance</option>
										<option value="ADNIC" <?= ($customer->insurance_company == 'ADNIC')?"selected":""; ?>>ADNIC</option>
										<option value="Nextcare" <?= ($customer->insurance_company == 'Nextcare')?"selected":""; ?>>Nextcare(orient is not acceptable)</option>
									</select>

									<?php if(isset($validator) && $validator->hasError('insurance_company')): ?>
									<div class="text-danger"><?= $validator->getError('insurance_company') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="row">
							
							<div class="col-md-4">
								<div class="form-group">
									<label for="nationality">Nationality</label>
									<input type="text" name="nationality" id="nationality" class="form-control" value="<?= $customer->nationality ?>">

									<?php if(isset($validator) && $validator->hasError('nationality')): ?>
									<div class="text-danger"><?= $validator->getError('nationality') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<hr />

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="photo">Profile Photo</label>
									<input type="file" name="photo" id="photo" class="form-control">

									<?php if(isset($validator) && $validator->hasError('photo')): ?>
									<div class="text-danger"><?= $validator->getError('photo') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="emirates_pc">Emirates ID Proof</label>
									<input type="file" name="emirates_pc" id="emirates_pc" class="form-control">

									<?php if(isset($validator) && $validator->hasError('emirates_pc')): ?>
									<div class="text-danger"><?= $validator->getError('emirates_pc') ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="insurance_pc">Insurance Proof</label>
									<input type="file" name="insurance_pc" id="insurance_pc" class="form-control">

									<?php if(isset($validator) && $validator->hasError('insurance_pc')): ?>
									<div class="text-danger"><?= $validator->getError('insurance_pc') ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-4">
								<?php if($customer->profile_photo != ''): ?>
								<img src="<?= site_url($customer->profile_photo) ?>" alt="Profile Photo" width="60%" style="display: block; margin: 0 auto;">
								<a href="<?= site_url('admin/customer/remove-file?id=' . EncryptId($customer->id) . '&type=profile&loc=' . urlencode($customer->profile_photo)) ?>"><button type="button" class="btn btn-danger btn-block">Remove</button></a>
								<?php endif; ?>
							</div>
							<div class="col-md-4">
								<?php if($customer->emirates_pc != ''): ?>
								<img src="<?= site_url($customer->emirates_pc) ?>" alt="Emirates ID Proof" width="60%" style="display: block; margin: 0 auto;">
								<a href="<?= site_url('admin/customer/remove-file?id=' . EncryptId($customer->id) . '&type=emirates&loc=' . urlencode($customer->emirates_pc)) ?>"><button type="button" class="btn btn-danger btn-block">Remove</button></a>
								<?php endif; ?>
							</div>
							<div class="col-md-4">
								<?php if($customer->insurance_pc != ''): ?>
								<img src="<?= site_url($customer->insurance_pc) ?>" alt="Insurance ID Proof" width="60%" style="display: block; margin: 0 auto;">
								<a href="<?= site_url('admin/customer/remove-file?id=' . EncryptId($customer->id) . '&type=insurance&loc=' . urlencode($customer->insurance_pc)) ?>"><button type="button" class="btn btn-danger btn-block">Remove</button></a>
								<?php endif; ?>
							</div>
						</div>

						<div class="row mt-4">
							<div class="col-md-6">
								<input type="submit" value="Update Customer" class="btn btn-success" />
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