<?= $this->extend('layouts/front_template.php') ?>

<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Nurse Profile</h1>
                
                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>
                    <li>Nurse Profile</li>
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
                    <li class="list-group-item"><a href="<?= site_url('nurse/profile') ?>">Profile</a></li>
                    <li class="list-group-item active"><a href="<?= site_url('nurse/bookings') ?>">Bookings</a></li>
                    <li class="list-group-item"><a href="<?= site_url('nurse/logout') ?>" style="color: red;">Logout</a></li>
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
                <h3>Your Bookings</h3>
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Date & Time</th>
                            <th>Booked For</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody><?php $x = 1; ?>
                        <?php foreach($bookings as $b): ?>
                        <tr>
                            <td><?= $x ?></td>
                            <td><?= $b->cfname . ' ' . $b->clname; ?></td>
                            <td><?= date('dS M, Y - h:i A', strtotime($b->service_date . ' ' . $b->service_time)); ?></td>
                            <td><?= $b->booked_for; ?></td>
                            <td><?= date('dS M, Y', strtotime($b->booking_date)); ?></td>
                            <td><?= ($b->status == 1) ? '<span class="label label-warning">Active</span>' : '<span class="label label-success">Completed</span>'; ?></td>
                            <td>
                                <span href="<?= site_url('nurse/booking/' . EncryptId($b->id) . '/done'); ?>" id="done"><i class="fa-solid fa-square-check text-success"></i></span>

                            </td>
                        </tr><?php $x++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if($nurse->status == 0){ ?>
                <a href="<?= site_url('nurse/profile-update'); ?>"><button class="btn btn-info">Complete your Profile</button></a>
                <?php } ?>
            </div>  
            <!-- END MAIN CONTENT -->
        </div>
    </div>
</div>


<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    
    $('#done').on('click', function(e){

        e.preventDefault();
        bootbox.confirm({ 
            size: "small",
            message: "Are you sure?",
            callback: function(result){ 
                alert("Fuck You");
            }
        })
    });
</script>
<?= $this->endSection(); ?>