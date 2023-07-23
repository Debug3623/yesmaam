
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
                <?php
                    $msg = session()->getFlashdata('msg');
                    if($msg) {
                        echo '<div class="alert alert-success">'. $msg .'</div>';
                    }
                ?>
                <h3 style="margin-bottom: 15px;">Your Nurse Bookings</h3>
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nurse Name</th>
                            <th>Date</th>
                          	<th>Time</th>
                            <th>Booked For</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody><?php $x = 1; ?>
                        <?php foreach($bookings as $b): ?>
                        <tr>
                            <td><?= $x ?></td>
                            <td><?= $b->nfname . ' ' . $b->nlname; ?></td>
                            <td><?= date('dS M, Y', strtotime($b->service_start_date)); ?> - <?= date('dS M, Y', strtotime($b->service_end_date)); ?></td>
                          	<td><?= date('dS M, Y', strtotime($b->service_time)); ?></td>
                            <td><?= $b->booked_for; ?> Days</td>
                            <td><?= ($b->status == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-success">Completed</span>'; ?></td>
                            
                        </tr><?php $x++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <br /><br /><br />
                <h3 style="margin-bottom: 15px;">Your Doctor Bookings</h3>
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Doctor</th>
                            <th>Date & Time</th>
                
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody><?php $x = 1; ?>
                        <?php foreach($d_bookings as $b): ?>
                        <tr>
                            <td><?= $x ?></td>
                            <td><?= $b->nfname . ' ' . $b->nlname; ?></td>
                            <td><?= date('dS M, Y - h:i A', strtotime($b->service_date . ' ' . $b->service_time)); ?></td>
                            
                            <td><?= date('dS M, Y', strtotime($b->booking_date)); ?></td>
                            <td><?= ($b->status == 1) ? '<span class="label label-warning">Active</span>' : '<span class="label label-success">Completed</span>'; ?></td>
                            <td>
                                <span href="<?= site_url('customer/booking/' . EncryptId($b->id) . '/done'); ?>" id="done"><i class="fa-solid fa-square-check text-success"></i></span>

                            </td>
                        </tr><?php $x++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
            </div>  
            <!-- END MAIN CONTENT -->
        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>