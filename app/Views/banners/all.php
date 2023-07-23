<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<span class="breadcrumb-item active">Banners</span>
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
					<div style="float: right;"><a href="<?= site_url('admin/banner/add') ?>"><button class="btn btn-success btn-sm">+ Add Banner</button></a></div>
					<b>All Banners</b>
				</div>
				<div class="card-body">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>#</th>
								<th>Image</th>
								<th>Link</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody><?php $x = 1; ?>
							<?php foreach($banners as $banner): ?>
							<tr>
								<td><?= $x ?></td>
								<td><img src="<?= site_url($banner->image); ?>" width="250px" alt=""></td>
								<td><a href="<?= $banner->href; ?>">Link</a></td>
								
								<td>
								<a href="<?= site_url('admin/banner/delete/' . EncryptId($banner->id)) ?>" class="deleteCategory"><button class="btn btn-danger btn-sm" style="padding: 2px 8px;"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i></button></a>
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
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
	
$(document).ready(function(){
	
	
	$('.deleteCategory').click(function(e){
		e.preventDefault();
		var obj = $(this);
		var url = obj.attr('href');
		bootbox.confirm({
		    title: "Delete Image?",
		    message: "Do you want to delete this Banner?",
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
		        		alert("Banner Data Deleted");
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