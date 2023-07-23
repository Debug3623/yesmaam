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
                
                <!-- BEGIN AGENT DETAIL -->
                <div class="agent-detail clearfix">
                    <div class="image col-md-5">
                        <img src="<?= site_url($nurse->photo) ?>" alt="" />
                    </div>
                    <div class="info col-md-7">
                        <header>
                            <h1><?= $nurse->first_name . ' ' . $nurse->last_name ?><br /><small>City: <?= $nurse->city ?></small></h1>
                            <p style="margin-top: 20px;"><b>Category: </b><?= $nurse->cate_name; ?></p>
                            
                            <p><b>Working Hours: </b><?= $nurse->working_hours; ?></p>
                            <p><b>Marital Status: </b><?= $nurse->marital_status; ?></p>
                            <p><b>Skills: </b><?= $nurse->skills; ?></p>
                            <p><b>Working Type: </b><?= $nurse->working_type; ?></p>
                             <?php
                                $birth_date = strtotime($nurse->date_of_birth);
                                $now = time();
                                $age = $now-$birth_date;
                                $a = $age/60/60/24/365.25;
                                $age = floor($a);
                             ?>
                             <p><b>Age: </b><?= $age; ?></p>
                        </header>
                        
                        <ul class="contact-us">
                        
                            <a href="<?= site_url('nurse/book/' . EncryptId($nurse->id)); ?>"><button class="btn btn-success">Book Now</button></a>
                        </ul>
                        <!--<ul class="contact-us">
                        
                            <li><i class="fa fa-map-marker"></i> 24th Street, New York, USA</li>
                            <li><i class="fa fa-phone"></i> 800-123-4567</li>
                        </ul>-->
                         
                    </div>
                </div>
                <!-- END AGENT DETAIL -->
                
                
                <p class="center"><?= $nurse->about; ?></p>
                <br/>
                
                
                <!-- BEGIN PROPERTIES ASSIGNED -->
                <h1 class="section-title">Similar Nurse</h1>
                <div id="assigned-properties" class="grid-style1 clearfix">
                    
                    <div class="grid-style1 clearfix">
                        
                        <?php foreach($similar_nurses as $nurse): ?>
                        <div class="item col-md-4" >
                            <div class="image">
                                <a href="properties-detail.html">
                                    <h3><?= $nurse->first_name . ' ' . $nurse->last_name ?></h3>
                                    <span class="location"><?= $nurse->city ?></span>
                                </a>
                                <img src="<?= site_url($nurse->photo) ?>" alt="" />
                            </div>
                            <div class="price">

                                <span>Book Now</span>
                            </div>
                            <ul class="amenities">
                                <li> <a href="<?= site_url('nurse/book/' . EncryptId($nurse->id)) ?>">View Profile</a></li>

                            </ul>
                        </div>
                        <?php endforeach; ?>
        


                        <div class="center"><a href="<?= site_url('/nurses') ?>" class="btn btn-default-color">View All Nurses</a></div>

                    </div>
                </div>
                
                 
                <!-- END PROPERTIES ASSIGNED -->
                
                
                <!-- BEGIN CONTACT FORM -->
                 
                <!-- END CONTACT FORM -->
                
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


                            
                            <select class="col-sm-12" id="category" name="category" data-placeholder="Category">
                                <option value=""> </option>
                                <?php foreach($categories as $cate): ?>
                                <option value="<?= $cate->id ?>"><?= $cate->name ?></option>
                                <?php endforeach; ?>
                             
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