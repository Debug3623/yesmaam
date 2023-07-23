<?= $this->extend('layouts/front_template.php') ?>


<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Doctor Registration</h1>

                <ul class="breadcrumb">
                    <li><a href="index.html">Home </a></li>

                    <li><a href="#">Create Account</a></li>
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
                        <form class="form-style" method="post" action="<?= site_url('doctor/register') ?>" enctype="multipart/form-data">
                            <label for="firstname"> First Name </label> 
                            <?php if(isset($validator) && $validator->hasError('firstname')): ?>
                            <div class="text-danger"><?= $this->getError('firstname') ?>
                            <?php endif; ?>
                            <input type="text" name="firstname" placeholder="First Name*" class="form-control" id="firstname" value="<?= set_value('firstname') ?>" />


                            <label for="middlename"> Middle Name </label>    
                            <?php if(isset($validator) && $validator->hasError('middlename')): ?>
                            <div class="text-danger"><?= $this->getError('middlename') ?>
                            <?php endif; ?>
                            <input type="text" name="middlename" placeholder="Middle Name*" class="form-control" id="middlename" value="<?= set_value('middlename') ?>" />


                            <label for="lastname"> Last Name </label>  
                            <?php if(isset($validator) && $validator->hasError('lastname')): ?>
                            <div class="text-danger"><?= $this->getError('lastname') ?>
                            <?php endif; ?>
                            <input type="text" name="lastname" placeholder="Last Name*" class="form-control" id="lastname" value="<?= set_value('lastname') ?>" />


                            <label for="dob"> Date of Birth </label>  
                            <?php if(isset($validator) && $validator->hasError('dob')): ?>
                            <div class="text-danger"><?= $this->getError('dob') ?>
                            <?php endif; ?>
                            <input type="date" name="dob" placeholder="Date of Birth" class="form-control" id="dob" value="<?= set_value('dob') ?>" />



                            <label for="address"> Address </label>  
                            <?php if(isset($validator) && $validator->hasError('address')): ?>
                            <div class="text-danger"><?= $this->getError('address') ?>
                            <?php endif; ?>  
                            <input type="text" name="address" placeholder="Address" class="form-control" id="address" value="<?= set_value('address') ?>" />



                            <label for="email"> Email </label>  
                            <?php if(isset($validator) && $validator->hasError('email')): ?>
                            <div class="text-danger"><?= $this->getError('email') ?>
                            <?php endif; ?>
                            <input type="email" name="email" placeholder="Email Address*" class="form-control" id="email" value="<?= set_value('email') ?>" />



                            
                            <label for="aboutyou"> About You </label>  
                            <?php if(isset($validator) && $validator->hasError('aboutyou')): ?>
                            <div class="text-danger"><?= $this->getError('aboutyou') ?>
                            <?php endif; ?>
                            <textarea rows="5" cols="15" name="aboutyou" class="form-control" id="aboutyou"><?= set_value('aboutyou') ?></textarea>



                            <label for="specialities"> Specialities </label> 
                            <?php if(isset($validator) && $validator->hasError('specialities')): ?>
                            <div class="text-danger"><?= $this->getError('specialities') ?>
                            <?php endif; ?> 
                            <textarea rows="5" cols="15" name="specialities" class="form-control" id="specialities"><?= set_value('specialities') ?></textarea>




                            <label for=""> Category </label>   
                            <?php if(isset($validator) && $validator->hasError('category')): ?>
                            <div class="text-danger"><?= $this->getError('category') ?>
                            <?php endif; ?>
                            <select class="form-control" name="category" id="category">
                                <option value="Baby Sitting">Physician</option>
                                <option value="Elderly Care service">Surgical</option>
                            </select>




                            <label for="languages"> Language can speak </label>   
                            <?php if(isset($validator) && $validator->hasError('languages')): ?>
                            <div class="text-danger"><?= $this->getError('languages') ?>
                            <?php endif; ?>
                            <input type="text" name="languages" placeholder="Language can speak" class="form-control" id="languages" value="<?= set_value('languages') ?>" />



                             
                            <label for="photo"> Photo </label> 
                            <?php if(isset($validator) && $validator->hasError('photo')): ?>
                            <div class="text-danger"><?= $this->getError('photo') ?>
                            <?php endif; ?> 
                            <input type="file" name="photo" class="form-control" id="photo" value="<?= set_value('photo') ?>" />
                            
                            

                            <div class="checkbox">
                                <label for="terms">
                                    <?php if(isset($validator) && $validator->hasError('terms')): ?>
                                        <div class="text-danger"><?= $this->getError('terms') ?>
                                    <?php endif; ?>
                                    <input type="checkbox" name="terms" id='terms"'> I confirm that I have read, understood and accept the <a href="#">Terms of Use</a> and the <a href="#">Privacy Policy</a>.
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-fullcolor">Create Account</button>
                            
                        </form>
                        
                        
                    </div>


                </div>

                <div class="login-info col-sm-4 col-sm-offset-1">
                    <h1>Create Doctor Profile</h1>
                    <p>Add your information to Profile</p>
                    <p><img src="<?= site_url('front/') ?>images/cropped-nurse1.png" width="250" height="250"></p>
                </div>
            </div>  
            <!-- END MAIN CONTENT -->

        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>