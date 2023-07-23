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
            <!-- BEGIN SIDEBAR 
            <div class="sidebar col-sm-3">
                <ul class="list-group">
                    <li class="list-group-item active"><a href="">Profile</a></li>
                    <li class="list-group-item"><a href="">Bookings</a></li>
                    <li class="list-group-item"><a href="<?= site_url('nurse/logout') ?>" style="color: red;">Logout</a></li>
                </ul>
            </div>-->
            <!-- END SIDEBAR -->
            <div class="col-md-3">
              <?php if($nurse->photo): ?>
              <img src="<?= site_url($nurse->photo) ?>" class="img img-responsive" style="width: 50%;" />
              <?php else: ?>
              <img src="<?= site_url('images/nurses/nurse placeholder.jpg') ?>" class="img img-responsive" style="width: 50%;" />
              <?php endif; ?>
                
                <p>
                    <a href="<?= site_url('nurse/profile') ?>" class="btn btn-primary" style="width: 50%; margin-top: 5px;">Profile</a><br />
                    <a href="<?= site_url('nurse/bookings') ?>" class="btn btn-warning" style="width: 50%; margin-top: 5px;">Bookings</a><br />
                    <a href="<?= site_url('nurse/logout') ?>" class="btn btn-danger" style="width: 50%; margin-top: 5px;">Logout</a>
                </p>
            </div>


            <!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-8">
                <?php
                    $msg = session()->getFlashdata('msg');
                    if($msg) {
                        echo '<div class="alert alert-success">'. $msg .'</div>';
                    }
                ?>
                <table class="table table-bordered">
                    <tr>
                        <th width="24%">Full Name</th>
                        <td><?= $nurse->first_name, ' ', $nurse->middle_name . ' ' . $nurse->last_name ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $nurse->email ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?= $nurse->phone ?></td>
                    </tr>
                    <tr>
                        <th>Emirates ID</th>
                        <td><?= $nurse->EID ?></td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td><?= $nurse->address ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?= $nurse->address ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $nurse->email ?></td>
                    </tr>

                    <tr>
                        <th>Phone no.</th>
                        <td><?= $nurse->phone ?></td>
                    </tr>

                    <tr>
                        <th>About</th>
                        <td><?= $nurse->about ?></td>
                    </tr>

                    <tr>
                        <th>Expertise</th>
                        <td><?= $nurse->expertise ?></td>
                    </tr>

                    <tr>
                        <th>Category</th>
                        <td><?= $nurse->category ?></td>
                    </tr>

                    <tr>
                        <th>Working Hours</th>
                        <td><?= $nurse->working_hours ?></td>
                    </tr>

                    <tr>
                        <th>Date of Birth</th>
                        <td><?= $nurse->date_of_birth ?></td>
                    </tr>

                    <tr>
                        <th>Marital Status</th>
                        <td><?= $nurse->marital_status ?></td>
                    </tr>
                    <tr>
                        <th>Skills</th>
                        <td><?= $nurse->skills ?></td>
                    </tr>

                    <tr>
                        <th>Visa Type</th>
                        <td><?= $nurse->visa_type ?></td>
                    </tr>

                    <tr>
                        <th>Working Type</th>
                        <td><?= $nurse->working_type ?></td>
                    </tr>

                    <tr>
                        <th>Nationality</th>
                        <td><?= $nurse->nationality ?></td>
                    </tr>

                    <tr>
                        <th>Passport</th>
                        <td><a href="<?= site_url($nurse->passport); ?>"><?= $nurse->passport_no ?></a></td>
                    </tr>

                    <tr>
                        <th>Experience</th>
                        <td><?= $nurse->experience ?></td>
                    </tr>

                    <tr>
                        <td><b>Status</b></td>
                        <td>
                            <?php if($nurse->status == 0): ?>
                            <span class="label label-danger">Inactive</span>
                            <?php else: ?>
                            <span class="label label-success">Active</span>
                            <?php endif; ?>
                        </td> 
                    </tr>
                </table>
                <?php if($nurse->status == 0): ?>
                <a href="<?= site_url('nurse/profile-update'); ?>"><button class="btn btn-info">Complete your Profile</button></a>
                <?php else: ?>
                    <a href="<?= site_url('nurse/profile-update'); ?>"><button class="btn btn-primary">Edit Profile</button></a>
                <?php endif; ?>
            </div>  
            <!-- END MAIN CONTENT -->
        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>