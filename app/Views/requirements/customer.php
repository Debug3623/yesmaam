<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">All customer Requirements</span>
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
					<h4><?= esc($customer->first_name . ' ' . $customer->last_name) ?>'s Requirements</b>
				</div>
				<div class="card-body">
					<table class="table table-sm table-bordered ">
						<thead>
							<tr>
								<th>#</th>
								<th>Category</th>
								<th>Date</th>
								<th>Time</th>
								<th>Area</th>
								<th>Details</th>
								<th>Budget</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($requirements as $cus): ?>
							<tr>
								<td><?= $x ?></td>
								<td><?= esc($cus->cate_name) ?></td>
								<td><?= date('d/m/Y', strtotime($cus->start_date)) . " - " . date('d/m/Y', strtotime($cus->end_date)); ?></td>
								<td><?= date('h:i A', strtotime($cus->start_time)) . " - " . date('h:i A', strtotime($cus->end_time)); ?></td>
								<td><?= esc($cus->area) ?></td>
								<td><?= esc($cus->details) ?></td>
								<td><?= esc($cus->budget) ?></td>
								<td><span class="badge badge-<?= ($cus->status == 'completed')?"success":"danger"; ?>"><?= ucfirst(esc($cus->status)) ?></span></td>
								<td>
									<a href="<?= site_url('admin/requirement/update/' . EncryptId($cus->id)) ?>">
										<button class="btn btn-primary btn-sm" style="padding: 2px 8px;">
											<i class="fa-solid fa-pen-to-square" style="font-size: 13px;"></i>
										</button>
									</a>

									<a href="<?= site_url('admin/requirement/bids/' . EncryptId($cus->id)) ?>">
										<button class="btn btn-primary btn-sm" style="padding: 2px 8px;">
											<i class="fa-solid fa-hand-pointer" style="font-size: 13px;"></i>
										</button>
									</a>

									<a href="<?= site_url('admin/requirement/delete/' . EncryptId($cus->id)) ?>" class="deleteCategory">
										<button class="btn btn-danger btn-sm" style="padding: 2px 8px;">
											<i class="fa-solid fa-trash-can" style="font-size: 13px;"></i>
										</button>
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

	$('.deleteCategory').click(function(e){
		e.preventDefault();
		var obj = $(this);
		var url = obj.attr('href');
		bootbox.confirm({
		    title: "Delete Requirement?",
		    message: "Do you want to delete this Requirement and it's bids? This cannot be undone.",
		    buttons: {
		        cancel: {
		            label: '<i class="fa fa-times"></i> Cancel'
		        },
		        confirm: {
		            label: '<i class="fa fa-check"></i> Delete'
		        }
		    },
		    callback: function (result) {
		        // $.get(url, function(data, status){
		        // 	if(result) {
		        // 		alert("Customer Data Deleted");
		        // 		location.reload();
		        // 	}
		        // 	else {
		        // 		alert("Unable to delete.");
		        // 	}
		        	
		        // });
		    }
		});
	});
});
</script>
<?= $this->endSection(); ?>


<?= $this->section('forms'); ?>

<?= $this->include('booking/add_form.php'); ?>

<?= $this->endSection(); ?>