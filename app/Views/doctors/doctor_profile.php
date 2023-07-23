<?= $this->extend('layouts/front_template.php') ?>


<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Doctor Profile</h1>

                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>

                    <li><a href="#">Doctor Profile</a></li>
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
                
                <!-- BEGIN AGENT DETAIL -->
                <div class="agent-detail clearfix">
                    <div class="image col-md-5">
                        <img src="<?= site_url($doctor->photo) ?>" alt="" />
                    </div>

                    <div class="info col-md-7">
                        <header>
                            <h2><?= $doctor->first_name . ' ' . $doctor->last_name ?> <small>City: <?= $doctor->city ?></small></h2>
                            <p><b>Category: </b><?= $doctor->cate_name; ?></p>
                            <p><b>Specialities: </b><?= $doctor->specialities; ?></p>
                            <p><b>Speaking Languages: </b><?= $doctor->speaking_languages; ?></p>

                             
                        </header>
                        
                        <ul class="contact-us">
                        
                            <a href="<?= site_url('doctor/book/' . EncryptId($doctor->id)); ?>"><button class="btn btn-success">Book Now</button></a>
                        </ul>
                        <!--<ul class="contact-us">
                        
                            <li><i class="fa fa-map-marker"></i> 24th Street, New York, USA</li>
                            <li><i class="fa fa-phone"></i> 800-123-4567</li>
                        </ul>-->
                         
                    </div>
                </div>
                <!-- END AGENT DETAIL -->
                
                
                <p class="center"><?= $doctor->about_you; ?></p>
                <br/>
                
                <?php if(count($similar_doctors)): ?>
                <!-- BEGIN PROPERTIES ASSIGNED -->
                <h1 class="section-title">Similar Doctors</h1>
                <div id="assigned-properties" class="grid-style1 clearfix">
                    
                    <div class="grid-style1 clearfix">
                        
                        <?php foreach($similar_doctors as $doctor): ?>
                        <div class="item col-md-4">
                            <div class="image">
                                <a href="properties-detail.html">
                                    <h3><?= $doctor->first_name . ' ' . $doctor->last_name ?></h3>
                                    <span class="location"></span>
                                </a>
                                <img src="<?= site_url($doctor->photo) ?>" alt="" />
                            </div>
                            <div class="price">

                                <span>Book Now</span>
                            </div>
                            <ul class="amenities">
                                <li> <a href="<?= site_url('doctor/book/' . EncryptId($doctor->id)) ?>">View Profile</a></li>

                            </ul>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                 
                <!-- END PROPERTIES ASSIGNED -->
                
                
                <!-- BEGIN CONTACT FORM -->
                 
                <!-- END CONTACT FORM -->
                
            </div>  
            <!-- END MAIN CONTENT -->
            
            
            <!-- BEGIN SIDEBAR -->
            <div class="sidebar gray col-sm-4">
                
                <?= $this->include('doctors/forms/search_form.php') ?>
                 
                <!-- END NEWSLETTER -->
                
            </div>
            <!-- END SIDEBAR -->
            
        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>