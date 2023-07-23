<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">All Bookings</span>
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
					<b>All Doctor Bookings</b>
				</div>
				<div class="card-body">
					<table class="table table-sm table-hover ">
						<thead>
							<tr>
								<th>#</th>
								<th>Customer</th>
								<th>Doctor</th>
								<th>Service Date & Time</th>
                                <th>Doctor Status</th>
								<th>Prescription</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($doctors as $cus): ?>
							<tr>
								<td width="8%"><?= $x ?></td>
								<td><?= $cus->cfname, ' ', $cus->clname; ?></td>
								<td><?= $cus->dfname, ' ', $cus->dlname; ?></td>
								<td><?= date('d M, Y H:i', strtotime($cus->service_date . ' ' . $cus->service_time)); ?></td>
								<td></td>
								<td>
									<?php if($cus->prescription != ""): ?>
										<a href="<?= site_url($cus->prescription) ?>" target="_blank"><i class="fa-solid fa-file-invoice" style="font-size: 22px;"></i></a>
									<?php else: ?>

									<?php endif; ?>
								</td>
								<td>
									<?php
										$status = "";
										if($cus->status == 'progress') {
											$status = 'info';
										}
										else if($cus->status == 'pending') {
											$status = 'warning';
										}
										else if($cus->status == 'complete') {
											$status = 'success';
										}
										else if($cus->status == 'cancelled') {
											$status = 'danger';
										}
									?>
									<span class="badge badge-<?= $status; ?>"><?= ucfirst($cus->status) ?></span>
								</td>
								<td width="10%">
									<a href="<?= site_url('admin/booking/doctor/single/' . EncryptId($cus->id)) ?>">
									<button class="btn btn-primary btn-sm" type="button" style="padding: 2px 8px;">
										<i class="fas fa-edit" style="font-size: 15px;"></i>
									</button>
									</a>

									<a href="<?= site_url('admin/booking/doctor/upload-prescription/' . EncryptId($cus->id)) ?>" class="prescription" title="Upload prescription">
										<button type="button" class="btn btn-info btn-sm" style="padding: 2px 8px;">
											<i class="fa-regular fa-rectangle-list" style="font-size: 12px;"></i>
										</button>
									</a>
									<a href="<?= site_url('admin/booking/delete/' . EncryptId($cus->id)) ?>" class="deleteCategory">
										<button class="btn btn-danger btn-sm" style="padding: 2px 8px;">
											<i class="fa-solid fa-trash-can" style="font-size: 12px;"></i>
										</button>
									</a>
								</td>
								</td>
							</tr>
							<?php $x++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			

		</div>

	</div>

</div>
<?= $this->include('booking/partials/prescription_form') ?>
<!-- /content area -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('.prescription').click(function(e){
		e.preventDefault();
		//alert("Hello");
		$('#exampleModalCenter').modal('show');
		var obj = $(this);
		$('#prescriptionForm').prop('action', obj.prop('href'));
		// // alert(obj.prop('href'));
	});
});
$(document).ready(function(){
	$('.table').DataTable();

	$('.abc').click(function(e){
		e.preventDefault();
		var obj = $(this);
		var url = obj.attr('href');

		bootbox.prompt({
		    title: "This is a prompt, vertically centered!", 
		    centerVertical: true,
		    callback: function(result){ 
		        $.post(url, {link: result}, function(data, status){
		        	location.reload();
		        });
		    }
		});
		//alert('Clicked');
	});

	
});
</script>
<?= $this->endSection(); ?>


<?= $this->section('forms'); ?>

<?= $this->include('booking/add_form.php'); ?>

<?= $this->endSection(); ?>