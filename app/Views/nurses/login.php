<?= $this->extend('layouts/front_template.php') ?>



<?= $this->section('content'); ?>
<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    <div class="container">
        <div class="row">

            <!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-12">

                <div class="login col-sm-5 col-sm-offset-1">
                    <h1 class="center">Log in to your Account</h1>

                    <div class="col-sm-12">

                        <form class="form-style" method="post" action="<?= site_url('nurse/login') ?>">
                            
                            <?php if($err_msg): ?>
                                <div class="alert alert-danger"><?= $err_msg ?></div>
                            <?php endif; ?>


                            <label for="username"> Email </label>      
                            <?php if(isset($validator) && $validator->hasError('username')): ?>
                                <div class="text-danger"><?= $validator->getError('username'); ?></div>
                            <?php endif; ?> 
                            <input type="text" id="username" value="<?= set_value('username') ?>" name="username" placeholder="Username" class="form-control" />



                            <label for="password"> Password </label>  
                            <?php if(isset($validator) && $validator->hasError('password')): ?>
                                <div class="text-danger"><?= $validator->getError('password'); ?></div>
                            <?php endif; ?>  
                            <input type="password" id="password" name="password" placeholder="Password" class="form-control" />



                            <button type="submit" class="btn btn-fullcolor">Log in</button>
                        </form>

                        <p class="recover-pass"><a href="">Lost Password?</a></p>

                        <a href="<?= site_url('nurse/register') ?>" class="btn btn-default-color">Create New Account</a>
                    </div>


                </div>

                <div class="login-info col-sm-4 col-sm-offset-1">
                    <h1>Nurse Login</h1>
                    <p>Login for booking the service of nurse or doctor</p>


                    <p><img src="<?= site_url('front/') ?>images/cropped-nurse1.png" width="250" height="250"></p>
                </div>
            </div>  
            <!-- END MAIN CONTENT -->

        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>