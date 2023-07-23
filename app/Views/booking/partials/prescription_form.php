<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Upload Prescription</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <form method="post" action="" id="prescriptionForm" enctype="multipart/form-data">
	  <div class="modal-body">
		<div class="form-group">
			<label for="file">Prescription</label>
			<input type="file" name="file" id="file" class="form-control" />
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Upload</button>
	  </div>
	  </form>
	</div>
  </div>
</div>