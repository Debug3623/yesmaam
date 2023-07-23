<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">Billing</span>
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
					<!--<div style="float: right;"><a href="<?= site_url('admin/customer/add') ?>"><button class="btn btn-success btn-sm">+ Add Employee</button></a></div>-->
					<b>All Billing Details</b>
				</div>
				<div class="card-body">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>#</th>
								<th>Company Name</th>
								<th>Purchase amount</th>
								<th>Purchase date</th>
								<th>Plan expire date</th>
								<th>Billing</th>
								<th>Payment Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($billing as $cus): ?>


							<tr>
								<td><?= $x ?></td>
								<td><?= $cus->company_name;?></td>
								<td><?= $cus->total_price; ?></td>
								<!--<td></td>-->
								<td>
								    <?= $cus->start_date; ?>
								</td>
									<td>
								    <?= $cus->end_date; ?>
								</td>
								
						        <td>
						            
						        </td>
								<td>
								    
                                  	<?php
										$status = "";
										if($cus->payment_status == 'pending') {
											$status = 'info';
										}
										
										else if($cus->payment_status == 'completed') {
											$status = 'success';
										}
										else if($cus->payment_status == 'cancelled') {
											$status = 'danger';
										}
									?>
									<span class="badge badge-<?= $status; ?>"><?= ucfirst($cus->payment_status) ?></span>
								</td>
							
		                    	<td width="10%">
									<a href="<?= site_url('admin/corporate/details/' . EncryptId($cus->id)) ?>">
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