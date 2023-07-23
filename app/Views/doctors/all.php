<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">Doctors</span>
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
					<div style="float: right;"><a href="<?= site_url('admin/doctor/add') ?>"><button class="btn btn-success btn-sm">+ Add Doctor</button></a></div>
					<b>All Doctors</b>
				</div>
				<div class="card-body">
					<table class="table table-sm table-stripped" id="myTable">
						<thead>
							<tr>
								<th>#</th>
								<th>Full Name</th>
								<th>Email</th>
								<!-- <th>Phone</th> -->
								<th>Specialist</th>
								
								<th>Confirmed</th>
								<th>Doctor For</th>
								<th>Avability</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($customers as $cus): ?>
							<tr>
								<td><?= $x ?></td>
								<td><?= $cus->first_name, ' ', $cus->last_name ?></td>
								<td><?= $cus->email; ?></td>
								<!-- <td></td> -->
								<td><?= $cus->specialities; ?></td>
								
								<td><?= ($cus->confirmed == 1) ? "Yes" : "No"; ?></td>
								<td>
									<select name="change_for" class="change_for" data-id="<?= EncryptId($cus->id) ?>" >
										<option value="web" <?= ($cus->doctor_from == 'web')?"selected":""; ?>>Web</option>
										<option value="app" <?= ($cus->doctor_from == 'app')?"selected":""; ?>>App</option>
									</select>
								</td>
								<td>
									<input type="checkbox" data-toggle="toggle" data-onstyle="info" data-size="xs" data-on="Yes" data-off="No" class="changeStatus" <?= ($cus->available == 'Yes') ? 'checked' : ''; ?> data-src="<?= site_url('admin/doctor/change-availibility/' . EncryptId($cus->id)) ?>">
								</td>
								<td>
									<table cellpadding="0" cellspacing="0">
										<tr>
											<!-- <td style="margin: 0; padding: 5px;">
												<?php if($cus->confirmed == 0): ?>
													<a href="<?= site_url('admin/doctor/confirm/' . EncryptId($cus->id)) ?>" id="confirm" title="Confirm"><button class="btn btn-success btn-sm" style="padding: 2px 8px;"><i class="fa-solid fa-check" style="font-size: 12px;"></i></button></a>
												<?php else: ?>
													<a href="<?= site_url('admin/doctor/hide/' . EncryptId($cus->id)) ?>" title="Hide"><i class="fa-solid fa-eye-slash text-primary" class="font-size: 18px"></i></a>
												<?php endif; ?>	
											</td> -->
											<td style="margin: 0; padding: 5px;">
												<a href="<?= site_url('admin/doctor/update/' . EncryptId($cus->id)) ?>"><button class="btn btn-primary btn-sm" style="padding: 2px 8px;"><i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i></button></a> 
											</td>
											<td style="margin: 0; padding: 5px;">
												<a href="<?= site_url('admin/doctor/delete/' . EncryptId($cus->id)) ?>" class="deleteCategory"><button class="btn btn-danger btn-sm" style="padding: 2px 8px;"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i></button></a>
											</td>
										</tr>
									</table>
									
										
										
								</td>		

							<?php $x++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			

		</div>

	</div>

</div>
<!-- /content area -->
<style>
	/* .table tbody td {
		
	} */
</style>
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
		    message: "Do you want to Confirm this Doctor?",
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
		        		alert("Doctor Confirmed");
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
		        		alert("Doctor Data Deleted");
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
			url += "/Yes";
		}
		else {
			url += "/No";
		}
		$.get(url, function(data, status){
			
		});
	});
	$('.table').DataTable({
		"scrollX": true
	});
});

$(document).ready(function(){
	$('.change_for').change(function(){
		var obj = $(this);
		var id = obj.data('id');
		var url = "<?= site_url('admin/change-doctor-for/') ?>" + id;
		var val = obj.val();
		$.post(url, {doctor_from: val}, function(result, status){
			if(result) {
				//location.reload();
			}
		});
	});
});
</script>
<?= $this->endSection(); ?>