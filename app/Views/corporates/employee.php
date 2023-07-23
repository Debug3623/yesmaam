<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">Employee</span>
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
					<b>All Employee</b>
				</div>
				<div class="card-body">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>#</th>
								<th>Company Name</th>
								<th>Phone</th>
								<!--<th>Company Licence</th>-->
								<th>Total Employee</th>
						    	<th>Pending Employee</th>
								<th>Aprroved Employee</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($corporate as $cus): ?>


							<tr>
								<td><?= $x ?></td>
								<td><a href="<?= site_url('admin/corporate/customer/'. EncryptId($cus->user_id)) ?>"><?= $cus->company_name;?></a></td>
								<td><?= $cus->mobile; ?></td>
								<!--<td></td>-->
								<td>
								    <?= $cus->employee; ?>
								</td>
									
								<td>
							    <?php if($cus->confirmed==0){ ?>

								<?= $cus->confirmed; ?>
								<?php }?>
								</td>
							
								<td>
							<?php	if($cus->confirmed==1){ ?>

								<?= $cus->confirmed; ?>
                             <?php }?>
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