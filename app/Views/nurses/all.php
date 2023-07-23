<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">Nurses</span>
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
					<div style="float: right;"><a href="<?= site_url('admin/nurse/add') ?>"><button class="btn btn-success btn-sm">+ Add Nurse</button></a></div>
					<b>All Nurses</b>
				</div>
				<div class="card-body">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>#</th>
								<th>Full Name</th>
								<th>Email</th>
								<th>Expertise</th>
								<th>Category</th>
								<th>Nurse For</th>
								<th>Status</th>
                              	<th>Available</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($nurses as $cus): ?>
							<tr>
								<td><?= $x ?></td>
								<td><?= $cus->first_name, ' ', $cus->last_name ?></td>
								<td><?= $cus->email; ?></td>
								<td><?= $cus->expertise; ?></td>
								<td><?= $cus->cate_name; ?></td>
								
								<td>
									<select name="change_for" class="change_for" data-id="<?= EncryptId($cus->id) ?>" >
										<option value="web" <?= ($cus->nurse_from == 'web')?"selected":""; ?>>Web</option>
										<option value="app" <?= ($cus->nurse_from == 'app')?"selected":""; ?>>App</option>
									</select>
								</td>
                              	<td>
									<span class="badge badge-<?= ($cus->confirmed == 1) ? 'success' : 'danger'; ?>"><?= ($cus->confirmed == 1) ? 'Confirmed' : 'Unconfirmed'; ?></span>
								
								</td>
								<td>
								    
									<input type="checkbox" data-toggle="toggle" data-onstyle="info" data-size="xs" data-on="Yes" data-off="No" class="changeStatus" <?= ($cus->available == 'Yes') ? 'checked' : ''; ?> data-nurse_id="<?= EncryptId($cus->id) ?>">
								
								</td>
								<td>
                                  <?php if($cus->confirmed == 0): ?>
                                  <a href="<?= site_url('admin/nurse/confirm/' . EncryptId($cus->id)) ?>" class="confirm">
                                  	<button class="btn btn-success btn-sm" style="padding: 2px 8px;"><i class="fa-solid fa-check" style="font-size: 12px;"></i></button>
                                  </a> 
                                   
                                  <?php endif; ?>
                                  <a href="<?= site_url('admin/nurse/update/' . EncryptId($cus->id)) ?>">
                                  	<button class="btn btn-primary btn-sm" style="padding: 2px 8px;"><i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i></button>
                                  </a> 
                                   
                                  <a href="<?= site_url('admin/nurse/delete/' . EncryptId($cus->id)) ?>" class="deleteCategory">
                                  	<button class="btn btn-danger btn-sm" style="padding: 2px 8px;"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i></button>
                                  </a></td>
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
	$('.confirm').click(function(e){
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

	$('.changeStatus').change(function(){
		var obj = $(this);
		var nurse_id = obj.data('nurse_id');
		var url = "<?= site_url('admin/nurse/change-availibility') ?>";
		
		var status = 0;
		if(obj.is(':checked') == true) {
			status = "Yes";
		}
		else {
			status = "No";
		}
		//alert(nurse_id);
		$.post(url, {nurse_id:nurse_id, status:status}, function(data, status){
			
		});
	});
	$('.table').DataTable();
});
$(document).ready(function(){
	$('.change_for').change(function(){
		var obj = $(this);
		var id = obj.data('id');
		var url = "<?= site_url('admin/change-nurse-for/') ?>" + id;
		var val = obj.val();
		$.post(url, {nurse_from: val}, function(result, status){
			if(result) {
				//location.reload();
			}
		});
	});
});
</script>
<?= $this->endSection(); ?>