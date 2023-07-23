<!-- Primary modal -->

<div id="modal_theme_primary" class="modal fade" tabindex="-1">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header bg-primary text-white">

				<h6 class="modal-title">Add Category</h6>

				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>



			<form method="post" action="<?= site_url('admin/category/add') ?>">

			<div class="modal-body">

				<div class="form-group">

					<label>Category Name</label>

					<input type="text" name="cname" id="cname" class="form-control" required />

				</div>



				<div class="form-group">

					<label>Category For</label>

					<select name="cfor" id="cfor" class="form-control" required>

						<option></option>

						<option value="doctor">Doctor</option>

						<option value="nurse">Nurse</option>

						<option value="babysitter">Babysitter</option>

					</select>

				</div>

			</div>



			<div class="modal-footer">

				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>

				<button type="submit" class="btn btn-primary">Save changes</button>

			</div>

			</form>

		</div>

	</div>

</div>

<!-- /primary modal -->