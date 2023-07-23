<?= $this->extend('layouts/front_template.php') ?>


<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Checkout</h1>

                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>

                    <li><a href="#">Checkout Form</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    <div class="container">
        <div class="row" style="margin-top: 20px;">
		    <div class="col-md-4 order-md-2 mb-4">
		        <h4 class="d-flex justify-content-between align-items-center mb-3">
		            <span class="text-muted"><b>Booking Details</b></span>
		        </h4>
		        <ul class="list-group mb-3"  style="padding-top: 10px;">
		            <li class="list-group-item d-flex justify-content-between lh-condensed">
		                <div>
		                    <img src="<?= site_url($item->photo); ?>" class="img-circle" alt="<?= $item->first_name . ' ' . $item->last_name ?>" width="100%" />
		                </div>
		                
		            </li>
		            <li class="list-group-item d-flex justify-content-between lh-condensed">
		                <div style="margin-top: 15px;">
		                    <h5 class="my-0"><b>Name</b></h5>
		                    <h3 ><?= $item->first_name . ' ' . $item->last_name ?></h3>
		                </div>
		                <div style="margin-top: 15px;">
		                    <h5 class="my-0"><b>Booking For</b></h5>
		                    <h3 style="color: #589ED9;">Nurse</h3>
		                </div>
		                <div style="margin-top: 15px;">
		                    <h5 class="my-0"><b>Amount</b></h5>
		                    <h3 style="color: #589ED9;"><?= ($booking['total_amount']) . ' ' . $setting->currency_type; ?></h3>
		                </div>
		                
		            </li>
		            
		            <li class="list-group-item d-flex justify-content-between" style="font-size: 20px;">
		                <span>Total (AED):</span>
		                <strong><?= $booking['total_amount'] ?></strong>
		            </li>
		        </ul>

		        
		    </div>
		    <div class="col-md-8 order-md-1">
		        <h4 class="mb-3">Billing Details</h4>
		        <form class="needs-validation" method="post" action="<?= site_url('order/summary') ?>" id="summaryForm">
		            <div class="row">
		                <div class="col-md-6 mb-3">
		                    <label for="firstName">First name</label>
		                    <input type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="<?= $customer->first_name ?>" required />
		                    
		                </div>
		                <div class="col-md-6 mb-3">
		                    <label for="lastName">Last name</label>
		                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" value="<?= $customer->last_name ?>" required />
		                    
		                </div>
		            </div>

		            <div class="mb-3">
		                <label for="email">Email </label>
		                <input type="email" class="form-control" id="email" name="email" value="<?= $customer->email ?>" required />
		                
		            </div>

		            
		            <div class="row">
		            	<div class="col-md-4 mb-3">
			                <label for="city">City</label>
			                <input type="text" class="form-control" id="city" name="city" value="<?= set_value('city') ?>" required />
			                
			            </div>

			            <div class="col-md-8 mb-3">
			                <label for="address">Address</label>
			                <input type="text" class="form-control" id="address" name="address" value="<?= $customer->address ?>" required />
			                
			            </div>
		            </div>
                  
                  	<div class="row">
		            	<div class="col-md-12 mb-3">
			                <label for="special_instruction">Special Instruction</label>
			                <input type="text" class="form-control" id="special_instruction" name="special_instruction" value="<?= set_value('special_instruction') ?>" required />
			            </div>
		            </div>
		            

		            
		            
		            <h3 class="mb-3" style="margin: 20px 0;">Payment</h3>

		            <div class="d-block my-3">
		                <div class="form-group">
		                	<label>Payment Method</label>
		                	<select id="payment_method" class="form-control" name="payment_method" required>
		                		<option></option>
		                		<option value="card">Pay by Card</option>
		                		<option value="cod">Cash of Delievery</option>
		                	</select>
		                </div>
		            </div>
		            
		            <hr class="mb-4">
		            <button class="btn btn-primary btn-lg btn-block" type="submit" id="sbtBtn">Continue to checkout</button>
		        </form>
		    </div>
		</div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
    $(document).ready(function(){
    	$('#summaryForm').on('submit', function(){
        	$('#sbtBtn').attr('disabled', 'disabled');
        });
    });
    
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>

<?= $this->endSection(); ?>