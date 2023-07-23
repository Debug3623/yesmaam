<?= $this->extend('layouts/front_template.php') ?>

<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Customer Profile</h1>
                
                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>
                    <li>Customer Profile</li>
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
            <!-- BEGIN SIDEBAR -->
            <div class="sidebar col-sm-3">
                <ul class="list-group">
                    <li class="list-group-item active"><a href="<?= site_url('customer/profile') ?>">Profile</a></li>
                    <li class="list-group-item"><a href="<?= site_url('customer/bookings') ?>">Bookings</a></li>
                    <li class="list-group-item"><a href="<?= site_url('customer/logout') ?>" style="color: red;">Logout</a></li>
                </ul>
            </div>
            <!-- END SIDEBAR -->


            <!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-8">
                <h3 style="margin-bottom: 30px;">Your Details</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Full Name</th>
                        <td><?= $customer->first_name, ' ', $customer->middle_name . ' ' . $customer->last_name ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $customer->email ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?= $customer->mobile ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?= $customer->address ?></td>
                    </tr>
                </table>
                
            </div>  
            <!-- END MAIN CONTENT -->
        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>