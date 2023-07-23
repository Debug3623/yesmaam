<?= $this->extend('layouts/base_template.php'); ?>



<?= $this->section('bread'); ?>

<div class="breadcrumb">

	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>

	<span class="breadcrumb-item active">Categories</span>

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

					<div style="float: right;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_theme_primary">Add Category +</button></div>

					<b>All Nurses</b>

				</div>

				<div class="card-body">

					<table class="table table-stripped">

						<thead>

							<tr>

								<th>#</th>

								<th>Name</th>
								
								<th>Type</th>

								<th>Status</th>

								<th>Actions</th>

							</tr>

						</thead>

						<tbody><?php $x = 1; ?>

							<?php foreach($categories as $cus): ?>

							<tr>

								<td><?= $x ?></td>

								<td><?= $cus->name; ?></td>

								<td><?= $cus->cate_for; ?></td>

								<td><?= ($cus->status == 1) ? 'Active' : 'Inactive'; ?></td>

								<td>

									<!-- <a href="<?= site_url('admin/category/delete/' . EncryptId($cus->id)) ?>" class="deleteCategory">Delete</a> -->

									<a href="<?= site_url('admin/category/delete/' . EncryptId($cus->id)) ?>" class="deleteCategory">
										<button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i></button>
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

		    title: "Delete Category?",

		    message: "Do you want to delete this Category? This cannot be undone.",

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

		        	alert("Category Deleted");

		        	location.reload();

		        });

		    }

		});

		



		/*

		

		*/

	});



	$('.table').DataTable();

});

</script>

<?= $this->endSection(); ?>



<?= $this->section('forms'); ?>



<?= $this->include('categories/add_form.php'); ?>



<?= $this->endSection(); ?>