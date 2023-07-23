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
					<b>All Nurse Bookings</b>
				</div>
				<div class="card-body">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>#</th>
								<th>Customer</th>
								<th>Nurse</th>
								<th>Amount</th>
								<th>Booking Date</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($doctors as $cus): ?>
							<tr>
								<td><?= $x ?></td>
								<td><?= $cus->cfname, ' ', $cus->clname; ?></td>
								<td><?= $cus->dfname, ' ', $cus->dlname; ?></td>
								
								<td><?= $cus->total_amount . ' ' . $settings->currency_type; ?> </td>
								<td><?= date('d M, Y', strtotime($cus->booking_date)); ?> </td>
								<td>
									<span class="badge <?= ($cus->booking_status == 'cancelled')?"badge-danger":""; ?>">
									<?= ucfirst($cus->booking_status) ?>
									</span>
								</td>
								<td>
									<a href="<?= site_url('admin/booking/nurse/single/' . EncryptId($cus->id)) ?>">
									<button class="btn btn-primary btn-sm" type="button"><i class="fas fa-edit" style="font-size: 15px;"></i></button>
									</a>
								</td>
							</tr><?php $x++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
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