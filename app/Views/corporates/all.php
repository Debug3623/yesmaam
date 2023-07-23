<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">Corporate</span>
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
					<div style="float: right;"><a href="<?= site_url('admin/corporate/add') ?>"><button class="btn btn-success btn-sm">+ Add Corporate</button></a></div>
					<b>All Corporate</b>
				</div>
				<div class="card-body">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>#</th>
								<th>Company Name</th>
								<th>Phone</th>
								<!--<th>Company Licence</th>-->
								<th>Corporate Status</th>
								<th>Payment Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($corporate as $cus): ?>


							<tr>
								<td><?= $x ?></td>
								<td><?= $cus->company_name;?></td>
								<td><?= $cus->mobile; ?></td>
								<!--<td></td>-->
								<td>
									<input type="checkbox" data-toggle="toggle" data-onstyle="info" data-size="xs" data-on="Approved" data-off="pending" class="changeStatus" <?= ($cus->confirmed == '1') ? 'checked' : ''; ?> data-src="<?= site_url('admin/corporate/change-availibility/' . EncryptId($cus->id)) ?>">
								</td>
								<td>
								<div class="form-check form-switch">
										
								<!--<input type="checkbox" data-toggle="toggle" data-onstyle="info" data-size="xs" data-on="Active" data-off="Inactive" class="changeStatus" <?= ($cus->status == 1) ? 'checked' : ''; ?> data-src="<?= site_url('admin/customer/change-status/' . EncryptId($cus->id)) ?>">-->
									<?php
									if($cus->payment_status == 'completed') {
									    echo '<span class="badge badge-success">Paid</span>';
									}
									elseif($cus->payment_status == 'pending'){
									    echo '<span class="badge badge-danger">Progress</span>';
									}
									?>
								</div>	
								
							
								</td>
								<td>
									<a href="<?= site_url('admin/corporate/update/' . EncryptId($cus->id)) ?>">
										<button class="btn btn-primary btn-sm" style="padding: 2px 8px;">
											<i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i>
										</button>
									</a>
									<a href="<?= site_url('admin/corporate/license/' . $cus->user_id) ?>">
										<button class="btn btn-info btn-sm" style="padding: 2px 8px;">
											<i class="fa-regular fa-rectangle-list" style="font-size: 12px;"></i>
										</button>
									</a>

									<a href="<?= site_url('admin/corporate/delete/' . EncryptId($cus->id)) ?>" class="deleteCategory">
										<button class="btn btn-danger btn-sm" style="padding: 2px 8px;">
											<i class="fa-solid fa-trash-can" style="font-size: 12px;"></i>
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
	$('.deleteCategory').click(function(e){
		e.preventDefault();
		var obj = $(this);
		var url = obj.attr('href');
		bootbox.confirm({
		    title: "Delete Customer?",
		    message: "Do you want to delete this Customer? This cannot be undone.",
		    buttons: {
		        cancel: {
		            label: '<i class="fa fa-times"></i> Cancel'
		        },
		        confirm: {
		            label: '<i class="fa fa-check"></i> Confirm'
		        }
		    },
		    callback: function (result) {
		        $.get(url, function(data, status){
		        	if(result) {
		        		alert("Customer Data Deleted");
		        		location.reload();
		        	}
		        	else {
		        		alert("Unable to delete.");
		        	}
		        	
		        });
		    }
		});
	});

	$('.changeStatus').change(function(){
		var obj = $(this);
		var url = obj.data('src');
		if(obj.is(':checked') == true) {
			url += "/1";
		}
		else {
			url += "/0";
		}
		$.get(url, function(data, status){
			
		});
	});
	$('.table').DataTable();
});
</script>
<?= $this->endSection(); ?>