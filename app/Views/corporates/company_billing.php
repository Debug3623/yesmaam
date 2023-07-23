<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<a href="<?= site_url('admin/booking/doctors') ?>" class="breadcrumb-item">Corporate Bookings</a>
	<span class="breadcrumb-item active">Edit Booking</span>
	
	<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

</style>
</div>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content area -->
<div class="content">

	<!-- Main charts -->
	<div class="row">
		<div class="col-xl-8">
			<div class="card">
				<div class="card-header bg-info text-white">
					<b class="text-uppercase">Billing Information</b>
				</div>
				<div class="card-body">
                    <?php if($msg): ?>
                    <div class="alert alert-success">
                        <strong>Success, </strong><?= $msg ?>
                    </div>
                    <?php endif; ?>
                    <form method="post" action="<?= site_url('admin/booking/doctor/single/' . EncryptId($booking->id)) ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <?php if(isset($validator) && $validator->has_error('company_name')): ?>
                                        <div class="text-danger"><?= $validator->getError('company_name'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="company_name" id="company_name" class="form-control" value="<?= $booking->company_name ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">Billing Name</label>
                                    <?php if(isset($validator) && $validator->has_error('first_name')): ?>
                                        <div class="text-danger"><?= $validator->getError('first_name'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $booking->first_name ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_email">Email</label>
                                    <?php if(isset($validator) && $validator->has_error('company_email')): ?>
                                        <div class="text-danger"><?= $validator->getError('company_email'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="company_email" id="company_email" class="form-control" value="<?= $booking->company_email ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <?php if(isset($validator) && $validator->has_error('city')): ?>
                                        <div class="text-danger"><?= $validator->getError('city'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="city" id="city" class="form-control" value="<?= $booking->city ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_address">Address</label>
                                    <?php if(isset($validator) && $validator->has_error('company_address')): ?>
                                        <div class="text-danger"><?= $validator->getError('company_address'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="company_address" id="company_address" class="form-control" value="<?= $booking->company_address ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <?php if(isset($validator) && $validator->has_error('mobile')): ?>
                                        <div class="text-danger"><?= $validator->getError('mobile'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="mobile" id="mobile" class="form-control" value="<?= $booking->mobile ?>" />
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_status">Booking Status</label>
                                    <?php if(isset($validator) && $validator->has_error('payment_status')): ?>
                                        <div class="text-danger"><?= $validator->getError('payment_status'); ?></div>
                                    <?php endif; ?>
                                    <select name="payment_status" id="payment_status" class="form-control">
                                        <option value="progress" <?= ($booking->payment_status == 'progress')?"selected":""; ?>>Progress</option>
                                        <option value="pending" <?= ($booking->payment_status == 'pending')?"selected":""; ?>>Pending</option>
                                        <option value="complete" <?= ($booking->payment_status == 'completed')?"selected":""; ?>>Complete</option>
                                    </select>
                                </div>
                                </div>
                              
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Plans</label>
                                    <?php if(isset($validator) && $validator->has_error('purchase_plane')): ?>
                                        <div class="text-danger"><?= $validator->getError('purchase_plane'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" readonly name="title" id="title" class="form-control" value="<?=$booking->title; ?>" />
                                </div>
                            
                        </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Booking Date</label>
                                    <?php if(isset($validator) && $validator->has_error('start_date')): ?>
                                        <div class="text-danger"><?= $validator->getError('start_date'); ?></div>
                                    <?php endif; ?>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?= date('Y-m-d', strtotime($booking->start_date)); ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <?php if(isset($validator) && $validator->has_error('end_date')): ?>
                                        <div class="text-danger"><?= $validator->getError('end_date'); ?></div>
                                    <?php endif; ?>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="<?= date('Y-m-d', strtotime($booking->end_date)); ?>" />
                                </div>
                            </div>
                        </div>
                        


                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_price">Amount</label>
                                    <?php if(isset($validator) && $validator->has_error('total_price')): ?>
                                        <div class="text-danger"><?= $validator->getError('total_price'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="total_price" id="total_price" class="form-control" value="<?= $booking->total_price; ?>" />
                                </div>
                                
                            </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Order Date</label>
                                    <?php if(isset($validator) && $validator->has_error('order_date')): ?>
                                        <div class="text-danger"><?= $validator->getError('order_date'); ?></div>
                                    <?php endif; ?>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?= date('Y-m-d', strtotime($booking->start_date)); ?>" />
                                </div>
                                
                            </div>
                    
                        </div>

                        <div class="row">
                          

                               <div class="col-md-6">
                                        <div class="form-group">
                                    <label for="payment_status">Payment Status</label>
                                    <?php if(isset($validator) && $validator->has_error('payment_status')): ?>
                                        <div class="text-danger"><?= $validator->getError('payment_status'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" readonly class="form-control" value="Card">
                                </div>
                                   </div>
                        </div>
                        
                      
                        
                  
                        <br>
                        
                      


                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" value="Update" class="btn btn-success">
                            </div>
                        </div>
                    </form>
					
				</div>
			</div>

            
			

		</div>
        <div class="col-xl-4">
			<div class="card">
				<div class="card-header bg-warning text-white">
					<b class="text-uppercase">Billing Information</b>
				</div>
				<div class="card-body">
					<table class="table table-bordered table-sm">
                        <tr>
                            <td width="45%"><b>Plan Employee</b></td>
                            <td><?= $booking->plan_employee; ?></td>
                        </tr>
                        <tr>
                            
                            <td width="45%"><b>Total Employee</b></td>
                            <td><?= $booking->total_employee; ?></td>
                        </tr>
                        <tr>
                            <td width="45%"><b>Total Amount</b></td>
                            <td><?= $booking->total_price; ?> AED</td>
                        </tr>
                    </table>
					
				</div>
			</div>

            <div class="card">
				<div class="card-header bg-primary text-white">
					<b class="text-uppercase">Booking Status</b>
				</div>
				<div class="card-body">

					<a href="<?= site_url('admin/booking/nurse/status/'. EncryptId($booking->id) .'?action=cancel'); ?>" id="cancelBooking">
                        <button type="button" class="btn btn-danger btn-block">Cancel Order</button>
                    </a>
				</div>
			</div>
			

		</div>

	</div>

</div>
<!-- /content area -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
	ClassicEditor
        .create( document.querySelector( '#about' ) )
        .catch( error => {
            console.error( error );
    });
$(document).ready(function(){
	$('.table').DataTable();

    
});
$('#cancelBooking').click(function(e){
    e.preventDefault();
    var obj = $(this);
    var url = obj.attr('href');

    bootbox.confirm({
        title: "Cancell Booking?",
        message: "Do you really want to cancel this Booking",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            if(result) {
                $.get(url, function(result, status){
                    if(status) {
                        bootbox.alert({
                            message: "Booking Cancelled",
                            backdrop: true,
                            callback: function () {
                                location = "<?= site_url('admin/booking/nurses') ?>";
                            }
                        });
                    }
                });
            }
        }
    });s

});
</script>
<?= $this->endSection(); ?>