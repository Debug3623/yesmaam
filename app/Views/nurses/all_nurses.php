<?= $this->extend('layouts/front_template.php') ?>


<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->

<!-- Revolution Slider CSS settings -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('front/') ?>rs-plugin/css/settings.css" media="screen" />
<div class="revslider-container">
                <div class="revslider" >
                    <ul>
                        <li data-transition="fade" data-slotamount="7">
                            <img src="<?= site_url('front/') ?>images/Slide_Nurse.jpg" alt="" />
                            <div class="caption sfr slider-title" data-x="70" data-y="120" data-speed="800" data-start="1300" data-easing="easeOutBack" data-end="9600" data-endspeed="700" data-endeasing="easeInSine">Best Quality Home care Service <br/>in Dubai</div>
                            <!--<div class="caption sfl slider-subtitle" data-x="75" data-y="190" data-speed="800" data-start="1500" data-easing="easeOutBack" data-end="9700" data-endspeed="500" data-endeasing="easeInSine"><br/>Baby sitting, Home Nursing, PCR Swab test,Doctor On call, Lab test, Physiotherapy service to your Doorstep. </div>-->
                            <a href="#" class="caption sfb btn btn-primary btn-lg" data-x="75" data-y="260" data-speed="800" data-easing="easeOutBack" data-start="1600" data-end="9800" data-endspeed="500" data-endeasing="easeInSine">Book Now</a>
                        </li>

                        <li data-transition="fade">
                            <img src="<?= site_url('front/') ?>images/Slide_Doctor.jpg" alt="" />
                            <div class="caption sfr slider-title" data-x="450" data-y="120" data-speed="800" data-start="1300" data-easing="easeOutBack" data-end="9600" data-endspeed="500" data-endeasing="easeInSine">Doctor on Call</div>
                            <div class="caption sfl slider-subtitle" data-x="455" data-y="190" data-speed="800" data-start="1500" data-easing="easeOutBack" data-end="9700" data-endspeed="500" data-endeasing="easeInSine">Best Service for Doctor on Call</div>
                            <a href="#" class="caption sfb btn btn-primary btn-lg" data-x="455" data-y="310" data-speed="800" data-easing="easeOutBack" data-start="1600" data-end="9800" data-endspeed="500" data-endeasing="easeInSine">Book Now</a>
                        </li>




                    </ul>
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
                    <div class="item col-md-4">
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
                        <ul class="amenities">
                          <li style="border:none;text-align:left;color:black;"> <h4><?= $nurse->first_name . ' ' . $nurse->last_name ?></h4> </li><br/>   
                          
                          <!--<li style="border:none;text-align:left;color:#000;"> <h5><b>Experience:</b> <?//= $nurse->experience; ?> </h5> </li><br/>
                          <li style="border:none;text-align:left;color:#000;"> <h5><b>Time:</b> Flexible </h5> </li><br/>-->
                         
                                       <br/><br/>
                            <li> <strong><a href="<?= site_url('nurse/profile/' . EncryptId($nurse->id)) ?>" class="btn btn-primary btn-lg">View Profile</a></strong></li>
							 
                        </ul>
                      <br/><br/>
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
 <script src="<?= site_url('front/') ?>js/common.js"></script>
         
               
        

        <!-- jQuery Revolution Slider -->
        <script type="text/javascript" src="<?= site_url('front/') ?>rs-plugin/js/jquery.themepunch.tools.min.js"></script>   
        <script type="text/javascript" src="<?= site_url('front/') ?>rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

        <!-- Template Scripts -->
         <script src="<?= site_url('front/') ?>js/variables.js"></script>
        <script src="<?= site_url('front/') ?>js/scripts.js"></script>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>