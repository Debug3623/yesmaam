<?= $this->extend('layouts/front_template.php') ?>

<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Login</h1>

                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>

                    <li><a href="<?= site_url('login') ?>">Customer Login</a></li>
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
                    <h1 class="center">Log in to your Account</h1>

                    <div class="col-sm-12">
                        <?php if($msg): ?>
                        <div class="alert alert-success"><?= $msg ?></div>
                        <?php endif; ?>
                        <?php if($errmsg): ?>
                        <div class="alert alert-danger"><?= $errmsg ?></div>
                        <?php endif; ?>
                        
                        <form class="form-style" method="post" action="<?= site_url('customer/login') ?>">
                            <label> Email </label>     
                            <?php if(isset($validator) && $validator->hasError('username')): ?>  
                            <div class="text-danger"><?= $this->getError('username'); ?></div>
                            <?php endif; ?>
                            <input type="text" name="username" placeholder="Username" class="form-control" />

                            <label> Password </label>   
                            <?php if(isset($validator) && $validator->hasError('password')): ?>  
                            <div class="text-danger"><?= $this->getError('password'); ?></div>
                            <?php endif; ?>

                            <input type="password" name="password" placeholder="Password" class="form-control" />


                            <button type="submit" class="btn btn-fullcolor">Log in</button>
                        </form>

                        <p class="recover-pass"><a href="">Lost Password?</a></p>

                        <a href="<?= site_url('customer/register') ?>" class="btn btn-default-color">Create New Account</a>
                    </div>


                </div>

                <div class="login-info col-sm-4 col-sm-offset-1">
                    <h1>Customer Login</h1>
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