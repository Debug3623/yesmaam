<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">Services</span>
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
					<b>All Services</b>
				</div>
				<div class="card-body">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>#</th>
								<th>Service Name</th>
								<th>Type</th>
								<th>Customer</th>
								<th>Booking Date</th>
								<th>Booking Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($bookings as $cus): ?>
							<tr>
								<td><?= $x ?></td>
								<td><?= $cus['service']->name ?></td>
								<td><?= $cus['service']->type ?></td>
								<td><?= $cus['booking']->first_name . ' ' . $cus['booking']->last_name ?></td>
								<td><?= date('d/m/Y', strtotime($cus['booking']->booking_date)); ?></td>
								<td>
									<span class="badge badge-<?= ($cus['booking']->status == 'pending')?"danger":"primary"; ?>"><?= ucfirst($cus['booking']->status); ?></span>
									
								</td>
                              	
								<td>
                                	<a href="<?= site_url('admin/booking/service/single/' . EncryptId($cus['booking']->id)) ?>">
                                  		<button class="btn btn-primary btn-sm" style="padding: 2px 8px;"><i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i></button>
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
	$('#confirm').click(function(e){
    	e.preventDefault();
      	var obj = $(this);
		var url = obj.attr('href');
      	
      	bootbox.confirm({
		    title: "Confirm Nurse?",
		    message: "Do you want to Confirm this Nurse? This cannot be undone.",
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
		        		alert("Nurse Data Confirmed");
		        		location.reload();
		        	}
		        	else {
		        		alert("Unable to Confirm Nurse.");
		        	}
		        	
		        });
		    }
		});
    });
  
  $('.deleteCategory').click(function(e){
		e.preventDefault();
		var obj = $(this);
		var url = obj.attr('href');
		bootbox.confirm({
		    title: "Delete Nurse?",
		    message: "Do you want to delete this Nurse? This cannot be undone.",
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
		        		alert("Nurse Data Deleted");
		        		location.reload();
		        	}
		        	else {
		        		alert("Unable to delete.");
		        	}
		        	
		        });
		    }
		});
	});

	$('.table').DataTable();
});
</script>
<?= $this->endSection(); ?>