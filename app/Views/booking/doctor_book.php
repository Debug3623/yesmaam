<?= $this->extend('layouts/front_template.php') ?>


<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Book a Doctor</h1>

                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>

                    <li><a href="#">Booking Form</a></li>
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
                    <h1 class="center">Book Service</h1>

                    <div class="col-sm-12">
                        <form class="form-style" method="post" action="<?= site_url('doctor/book/' . EncryptId($doctor->id)) ?>">

                            <?php if($msg): ?>
                            <div class="alert alert-success"><?= $msg ?></div>
                            <?php endif; ?>
                           
                            <label for="service_date"> Service Date</label>    
                            <?php if(isset($validator) && $validator->hasError('service_date')): ?>
                            <div class="alert alert-danger">
                                <?= $validator->getError('service_date'); ?>
                            </div>
                            <?php endif; ?>
                            <input type="date" id="service_date" name="service_date" min="<?= date('Y-m-d') ?>" placeholder="Service Date" class="form-control" />



                            <label for="service_time"> Service time </label> 
                            <?php if(isset($validator) && $validator->hasError('service_time')): ?>
                            <div class="alert alert-danger">
                                <?= $validator->getError('service_time'); ?>
                            </div>
                            <?php endif; ?>  
                            <input type="time" id="service_time" name="service_time" placeholder="Address" class="form-control" />
                             
                            
                            <button type="submit" class="btn btn-fullcolor">Book Now</button>
                            
                        </form>
                        
                        
                    </div>


                </div>

                <div class="login-info col-sm-4 col-sm-offset-1">
                    <h1>Book Doctor</h1>
                    
                    <p><img src="<?= site_url('images/doctor_booking.jpg') ?>" class="img-responsive" ></p>
                </div>
            </div>  
            <!-- END MAIN CONTENT -->

        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>