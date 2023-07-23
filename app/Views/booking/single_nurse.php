<?= $this->extend('layouts/base_template.php'); ?>

<?= $this->section('bread'); ?>
<div class="breadcrumb">
	<a href="<?= site_url('admin/dashboard') ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
	<a href="<?= site_url('admin/booking/nurses') ?>" class="breadcrumb-item">Nurses Bookings</a>
	<span class="breadcrumb-item active">Edit Booking</span>
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
                    <form method="post" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="billing_firstname">First Name</label>
                                    <?php if(isset($validator) && $validator->hasError('billing_firstname')): ?>
                                        <div class="text-danger"><?= $validator->getError('billing_firstname'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="billing_firstname" id="billing_firstname" class="form-control" value="<?= $booking->billing_firstname ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="billing_lastname">Last Name</label>
                                    <?php if(isset($validator) && $validator->hasError('billing_lastname')): ?>
                                        <div class="text-danger"><?= $validator->getError('billing_lastname'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="billing_lastname" id="billing_lastname" class="form-control" value="<?= $booking->billing_lastname ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="billing_email">Email</label>
                                    <?php if(isset($validator) && $validator->hasError('billing_email')): ?>
                                        <div class="text-danger"><?= $validator->getError('billing_email'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="billing_email" id="billing_email" class="form-control" value="<?= $booking->billing_email ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="billing_city">City</label>
                                    <?php if(isset($validator) && $validator->hasError('billing_city')): ?>
                                        <div class="text-danger"><?= $validator->getError('billing_city'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="billing_city" id="billing_city" class="form-control" value="<?= $booking->billing_city ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="billing_address">Address</label>
                                    <?php if(isset($validator) && $validator->hasError('billing_address')): ?>
                                        <div class="text-danger"><?= $validator->getError('billing_address'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="billing_address" id="billing_address" class="form-control" value="<?= $booking->billing_address ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_mobile">Customer Mobile</label>
                                    <?php if(isset($validator) && $validator->hasError('customer_mobile')): ?>
                                        <div class="text-danger"><?= $validator->getError('customer_mobile'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="customer_mobile" id="customer_mobile" class="form-control" value="<?= $booking->c_mobile ?>" />
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nurse">Nurse</label>
                                    <?php if(isset($validator) && $validator->hasError('nurse')): ?>
                                        <div class="text-danger"><?= $validator->getError('nurse'); ?></div>
                                    <?php endif; ?>
                                    <select name="nurse" id="nurse" class="form-control">
                                        <option value="">--Select Nurse--</option>
                                        <?php foreach ($nurses as $nurse): ?>
                                        <option value="<?= $nurse->id ?>" <?= ($nurse->id == $booking->nurse_id)?"selected":""; ?> ><?= $nurse->first_name . ' ' . $nurse->last_name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_status">Booking Status</label>
                                    <?php if(isset($validator) && $validator->hasError('booking_status')): ?>
                                        <div class="text-danger"><?= $validator->getError('booking_status'); ?></div>
                                    <?php endif; ?>
                                    <select name="booking_status" id="booking_status" class="form-control">
                                        <option value="pending" <?= ($booking->status == 'pending')?"selected":""; ?>>Pending</option>
                                        <option value="cancelled" <?= ($booking->status == 'cancelled')?"selected":""; ?>>Cancelled</option>
                                        <option value="completed" <?= ($booking->status == 'completed')?"selected":""; ?>>Completed</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Service Start Date</label>
                                    <?php if(isset($validator) && $validator->hasError('start_date')): ?>
                                        <div class="text-danger"><?= $validator->getError('start_date'); ?></div>
                                    <?php endif; ?>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?= date('Y-m-d', strtotime($booking->service_start_date)); ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="service_end_date">Service End Date</label>
                                    <?php if(isset($validator) && $validator->hasError('service_end_date')): ?>
                                        <div class="text-danger"><?= $validator->getError('service_end_date'); ?></div>
                                    <?php endif; ?>
                                    <input type="date" name="service_end_date" id="service_end_date" class="form-control" value="<?= date('Y-m-d', strtotime($booking->service_end_date)); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="service_time">Service Time</label>
                                    <?php if(isset($validator) && $validator->hasError('service_time')): ?>
                                        <div class="text-danger"><?= $validator->getError('service_time'); ?></div>
                                    <?php endif; ?>
                                    <input type="time" name="service_time" id="service_time" class="form-control" value="<?= date('H:i', strtotime($booking->service_time)); ?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booked_for">No of Days</label>
                                    <?php if(isset($validator) && $validator->hasError('booked_for')): ?>
                                        <div class="text-danger"><?= $validator->getError('booked_for'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="booked_for" id="booked_for" class="form-control" value="<?= $booking->booked_for; ?>" />
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="special_instruction">Special Instruction</label>
                                    <?php if(isset($validator) && $validator->hasError('special_instruction')): ?>
                                        <div class="text-danger"><?= $validator->getError('special_instruction'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="special_instruction" id="special_instruction" class="form-control" value="<?= $booking->special_instruction; ?>" />
                                </div>
                            </div>
                            
                        </div>


                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <?php if(isset($validator) && $validator->hasError('amount')): ?>
                                        <div class="text-danger"><?= $validator->getError('amount'); ?></div>
                                    <?php endif; ?>
                                    <input type="text" name="amount" id="amount" class="form-control" value="<?= $booking->amount; ?>" />
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_type">Payment Type</label>
                                    <?php if(isset($validator) && $validator->hasError('payment_type')): ?>
                                        <div class="text-danger"><?= $validator->getError('payment_type'); ?></div>
                                    <?php endif; ?>
                                    <select name="payment_type" id="payment_type" class="form-control">
                                        <option value="cod" <?= ($booking->payment_type == 'cod')?"selected":""; ?>>Cash on delivery</option>
                                        <option value="card" <?= ($booking->payment_type == 'card')?"selected":""; ?>>Online</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_date">Order Date</label>
                                    <?php if(isset($validator) && $validator->hasError('order_date')): ?>
                                        <div class="text-danger"><?= $validator->getError('order_date'); ?></div>
                                    <?php endif; ?>
                                    <input type="date" name="order_date" id="order_date" class="form-control" value="<?= date('Y-m-d', strtotime($booking->order_date)); ?>" />
                                </div>
                                
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" value="Update" class="btn btn-success">
                            </div>
                        </div>
                    </form>
					
				</div>
			</div>

            <!-- <div class="card">
				<div class="card-header bg-primary text-white">
					<b class="text-uppercase">Nurse Information</b>
				</div>
				<div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <td><img src="<?= site_url($booking->n_photo) ?>" width="100px" /></td>
                        </tr>
                        <tr>
                            <td><?= $booking->nurse_firstname, ' ', $booking->nurse_lastname ?></td>
                        </tr>
                    </table>
					
				</div>
			</div> -->
			

		</div>
        <div class="col-xl-4">
			<div class="card">
				<div class="card-header bg-warning text-white">
					<b class="text-uppercase">Billing Information</b>
				</div>
				<div class="card-body">
					<table class="table table-bordered table-sm">
                        <tr>
                            <td width="45%"><b>Base Rate</b></td>
                            <td><?= $setting->nurse_hour_rate; ?> AED</td>
                        </tr>
                        <tr>
                            <td width="45%"><b>Booking Hours</b></td>
                            <td><?= $setting->nurse_hour_rate * $booking->booked_for; ?> AED</td>
                        </tr>
                        <tr>
                            <td width="45%"><b>Order Total</b></td>
                            <td><?= $booking->amount; ?> AED</td>
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