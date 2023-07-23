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

                    <li><a href="#">Nurse Profile</a></li>
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
            <div class="main col-sm-8">
                <h1 class="section-title" >Book Your Nurse</h1>

                <div class="grid-style1 clearfix">
                    

                    <?php foreach($nurses as $nurse): ?>
                    <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                        <div class="image">
                            <a href="<?= site_url('nurse/profile/' . EncryptId($nurse->id)) ?>">
                                <h3><?= $nurse->first_name . ' ' . $nurse->last_name ?></h3>
                                <span class="location">City: <?= $nurse->city; ?></span>
                            </a>
                            <img src="<?= site_url($nurse->photo) ?>" alt="" />
                        </div>
                        <div class="price">

                            <span>Book Now</span>
                        </div>
                        <div>
                            <h3 align="center" style="margin-top: 10px;"><?= $nurse->first_name . ' ' . $nurse->last_name ?></h3>
                            <p align="center">Skills: <?= $nurse->skills; ?></p>

                        </div>
                        <ul class="amenities">
                            <li> <a href="<?= site_url('nurse/profile/' . EncryptId($nurse->id)) ?>">View Profile</a></li>

                        </ul>
                    </div>

                    <?php endforeach; ?>

                </div>


            </div>
            <!-- END MAIN CONTENT -->

            <!-- BEGIN SIDEBAR -->
            <div class="sidebar gray col-sm-4">
                
                <!-- BEGIN ADVANCED SEARCH -->
                <h2 class="section-title">Search Nurse</h2>
                <form method="get" action="<?= site_url('nurses') ?>">
                    <div class="form-group">
                        
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="location" placeholder="City,Location">
                            
                            <select class="col-sm-12" id="search_prop_type" name="work_type" data-placeholder="Working Type">
                                <option value=""> </option>
                                <option value="full_time">Full-Time</option>
                                <option value="part_time">Part-Time</option>
                             
                            </select>
                        

                        </div>

                        <p>&nbsp;</p>
                        <p class="center">
                            <button type="submit" class="btn btn-default-color">Search</button>
                        </p>
                    </div>
                </form>
                <!-- END ADVANCED SEARCH -->
                 
                <!-- END NEWSLETTER -->
                
            </div>
            <!-- END SIDEBAR -->

        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>