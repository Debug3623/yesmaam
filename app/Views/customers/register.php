<?= $this->extend('layouts/front_template.php') ?>


<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Registration</h1>

                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>

                    <li>Customer Register</li>
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
        <div class="row">

            <!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-12">

                <div class="login col-sm-5 col-sm-offset-1">
                    <h1 class="center">Create New Account</h1>

                    <div class="col-sm-12">
                        <?php if($msg): ?>
                            <div class="alert alert-success"><?= $msg ?></div>
                        <?php endif; ?>
                        <form class="form-style" method="post" action="<?= site_url('customer/register') ?>" id="customerRegForm">
                            <label for="firstname"> First Name </label> 
                            <?php if(isset($validator) && $validator->hasError('firstname')): ?>
                            <div class="text-danger"><?= $validator->getError('firstname'); ?></div>
                            <?php endif; ?>
                            <input type="text" name="firstname" placeholder="First Name*" class="form-control" value="<?= set_value('firstname'); ?>" />
                            

                            <label for="middlename"> Middle Name </label>    
                            <?php if(isset($validator) && $validator->hasError('middlename')): ?>
                            <div class="text-danger"><?= $validator->getError('middlename'); ?></div>
                            <?php endif; ?>
                            <input type="text" name="middlename" id="middlename" placeholder="Middle Name*" class="form-control"  value="<?= set_value('middlename'); ?>" />
                            


                            <label for="lastname"> Last Name </label>  
                            <?php if(isset($validator) && $validator->hasError('lastname')): ?>
                            <div class="text-danger"><?= $validator->getError('lastname'); ?></div>
                            <?php endif; ?>
                            <input type="text" name="lastname" id="lastname" placeholder="Last Name*" class="form-control"   value="<?= set_value('lastname'); ?>" />
                            


                            <label for="address"> Address </label> 
                          	<?php if(isset($validator) && $validator->hasError('address')): ?>
                            <div class="text-danger"><?= $validator->getError('address'); ?></div>
                            <?php endif; ?>
                            <input type="text" name="address" id="address" placeholder="Address" class="form-control"   value="<?= set_value('address'); ?>" />
                            


                            <label for="email"> Email </label> 
                          	<?php if(isset($validator) && $validator->hasError('email')): ?>
                            <div class="text-danger"><?= $validator->getError('email'); ?></div>
                            <?php endif; ?>
                            <input type="email" name="email" id="email" placeholder="Email Address*" class="form-control"   value="<?= set_value('email'); ?>" />
                            


                            <label for="phone"> Mobile Number </label>  
                          <?php if(isset($validator) && $validator->hasError('phone')): ?>
                            <div class="text-danger"><?= $validator->getError('phone'); ?></div>
                            <?php endif; ?>
                            <input type="number" name="phone" id="phone" placeholder="Phone*" class="form-control"   value="<?= set_value('phone'); ?>" />
                            


                           <label for="password"> Password </label>  
                          	<?php if(isset($validator) && $validator->hasError('password')): ?>
                            <div class="text-danger"><?= $validator->getError('password'); ?></div>
                            <?php endif; ?>
                            <input type="password" name="password" id="password" placeholder="Password*" class="form-control" value="<?= set_value('password'); ?>" />
                            


                            <label for="password2"> Confirm Password </label>   
                          	<?php if(isset($validator) && $validator->hasError('password2')): ?>
                            <div class="text-danger"><?= $validator->getError('password2'); ?></div>
                            <?php endif; ?>
                            <input type="password" name="password2" id="password2" placeholder="Confirm Password*" class="form-control"   value="<?= set_value('password2'); ?>" />
                            

                            <div class="checkbox">
                                <label for="terms">
                                    <input type="checkbox" name="terms" id="terms"> I confirm that I have read, understood and accept the <a href="#">Terms of Use</a> and the <a href="#">Privacy Policy</a>.
                                </label>
                            </div>
                            <?php if(isset($validator) && $validator->hasError('terms')): ?>
                            <div class="text-danger"><?= $validator->getError('terms'); ?></div>
                            <?php endif; ?>

                            <button type="submit" class="btn btn-fullcolor" id="registerBtn">Create Account</button>
                            
                        </form>
                        
                        <center><p>Already Register ? <a href="<?= site_url('customer/login'); ?>">Login</a></p>
                            </center>
                    </div>


                </div>

                <div class="login-info col-sm-4 col-sm-offset-1">
                    <h1>Create Customer Account</h1>
                    <p>Login for booking the service of nurse or doctor</p>


                    <p><img src="<?= site_url('front/'); ?>images/cropped-nurse1.png" width="250" height="250"></p>
                </div>
            </div>  
            <!-- END MAIN CONTENT -->

        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
	$(document).ready(function(){
    	$('#customerRegForm').on('submit', function(){
        	$('#registerBtn').attr('disabled', 'disabled');
        });
    });
</script>
<?= $this->endSection(); ?>




