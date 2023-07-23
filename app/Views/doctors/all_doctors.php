<?= $this->extend('layouts/front_template.php') ?>


<?= $this->section('breadcrumbs'); ?>

<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<link rel="stylesheet" type="text/css" href="<?= site_url('front/') ?>rs-plugin/css/settings.css" media="screen" />
<script src="<?= site_url('front/') ?>js/modernizr-2.8.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= site_url('infinite-slider.css') ?>">
<div class="revslider-container">
                <div class="revslider" >
                    <ul>
                      
                      <li data-transition="fade">
                            <img src="<?= site_url('front/') ?>images/Slide_Doctor.jpg" alt="" />
                            <div class="caption sfr slider-title" data-x="450" data-y="120" data-speed="800" data-start="1300" data-easing="easeOutBack" data-end="9600" data-endspeed="500" data-endeasing="easeInSine">Doctor on Call</div>
                            <div class="caption sfl slider-subtitle" data-x="455" data-y="190" data-speed="800" data-start="1500" data-easing="easeOutBack" data-end="9700" data-endspeed="500" data-endeasing="easeInSine">Best Service for Doctor on Call</div>
                            <a href="#" class="caption sfb btn btn-primary btn-lg" data-x="455" data-y="310" data-speed="800" data-easing="easeOutBack" data-start="1600" data-end="9800" data-endspeed="500" data-endeasing="easeInSine">Book Now</a>
                        </li> 
                        <li data-transition="fade" data-slotamount="7">
                            <img src="<?= site_url('front/') ?>images/Slide_Nurse.jpg" alt="" />
                            <div class="caption sfr slider-title" data-x="70" data-y="120" data-speed="800" data-start="1300" data-easing="easeOutBack" data-end="9600" data-endspeed="700" data-endeasing="easeInSine">Best Quality Home care Service <br/>in Dubai</div>
                            <!--<div class="caption sfl slider-subtitle" data-x="75" data-y="190" data-speed="800" data-start="1500" data-easing="easeOutBack" data-end="9700" data-endspeed="500" data-endeasing="easeInSine"><br/>Baby sitting, Home Nursing, PCR Swab test,Doctor On call, Lab test, Physiotherapy service to your Doorstep. </div>-->
                           <a href="#" class="caption sfb btn btn-primary btn-lg" data-x="75" data-y="260" data-speed="800" data-easing="easeOutBack" data-start="1600" data-end="9800" data-endspeed="500" data-endeasing="easeInSine">Book Now</a>
                        </li>

                    </ul>
                </div>
            </div>
<!-- END PAGE TITLE/BREADCRUMB -->
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<div class="parallax pattern-bg" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">About Us</h1>

                            <div id="featured-properties-slider" class="owl-carousel fullwidthsingle" data-animation-direction="from-bottom" data-animation-delay="250">
                                
                              
                              <div class="item">
                                    <!--<div class="" style="background-image:url("https://nurse.yesmaam.ae/public/front/images/telemedicine.jpg");">
                                        <a href="#"></a>
                                       
                                    </div>-->

                                    <div class="info" style="width:100%;">
                                      
                                        <img src="<?= site_url('front/') ?>images/1646631873_679968b4c26c385d0309-removebg-preview.png" style="float:left; width:300px; heigh:400px;"/>
                                        
                                      	<p style="float:right;width:70%;font-size:18px; font-weight:bold;"> We are a team of certified doctors specializing in offering the best treatments in the UAE. With the adequate experience of over 12 years, we have mastered 
              the skills of offering the best solutions with the latest technologies.</p>
                                      
                                        
                                    </div>
                                </div>
                                
                              
                            </div>

                        </div>
                    </div>
                </div>
            </div>


<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    <div class="container">
        <div class="row">
          

            <!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-8">
                <h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">Doctor on Call</h1>

                <div class="grid-style1 clearfix">
                    

                    <?php foreach($nurses as $nurse): ?>
                    <div class="item col-md-4">
                        <div class="image">
                            <a href="<?= site_url('doctor/profile/' . EncryptId($nurse->id)) ?>">
                                <h3><?= $nurse->first_name . ' ' . $nurse->last_name ?></h3>
                                <span class="location"><?= $nurse->city; ?></span>
                            </a>
                            <img src="<?= site_url($nurse->photo) ?>" alt="" />
                        </div>
                        <div class="price">

                            <span>Book Now</span>
                        </div>
                        <ul class="amenities">
                          <li style="border:none;"> <h4><?= $nurse->first_name . ' ' . $nurse->last_name ?></h4> </li>   
                                        <!--<li> <h6>Expertise: <?//= $nurse->expertise; ?> </h6> </li>-->
                          <li style="border:none;text-align:left;color:#000;"> <h5><b>Specialities:</b> <?= $nurse->specialities; ?> </h5> </li>
                          <li style="border:none;text-align:left;color:#000;display:block;"> <h5><b>License:</b> DHA </h5> </li>
                          
                          <br/>
                          
                          <li> <a href="<?= site_url('doctor/profile/' . EncryptId($nurse->id)) ?>" class="btn btn-primary btn-lg"><b>View Profile</b></a></li>

                        </ul>
                    </div>

                    <?php endforeach; ?>
                   
                </div>


            </div>
            <!-- END MAIN CONTENT -->

            <!-- BEGIN SIDEBAR -->
            <div class="sidebar gray col-sm-4">
                
                <!-- BEGIN ADVANCED SEARCH -->
                <h2 class="section-title">Search Doctor</h2>
                <form method="get" action="<?= site_url('doctors') ?>">
                    <div class="form-group">
                        
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="location" placeholder="City,Location">
                            
                            <select class="col-sm-12" id="search_prop_type" name="work_type" data-placeholder="Speciality">
                                <option value=""> </option>
                                <?php foreach($speciality as $s): ?>
                                <option value="<?= $s ?>"><?= $s ?></option>
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
<div class="revslider-container">
                <div class="revslider" >
                    <ul>
                     <li data-transition="fade">
                      <img src="<?= site_url('front/') ?>images/slide_insurance.jpg" alt="" />
                      </li>
                      
                  </ul>
                      </div>
                    </div>
<br/>
<!-- BEGIN PARTNERS WRAPPER -->


            <div class="parallax pattern-bg" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="section-title">All Insurance we accepted</h1>
                            <div class="container">
                              <section class="customer-logos slider">
                                <!--<div class="slide"><img src="<?//= site_url('front/') ?>images/Partner/1.png"></div>
                                <div class="slide"><img src="<?//= site_url('front/') ?>images/Partner/2.png"></div>
                                <div class="slide"><img src="<?//= site_url('front/') ?>images/Partner/3.png"></div>
                                <div class="slide"><img src="<?//= site_url('front/') ?>images/Partner/4.png"></div>-->
                                <?php for($x = 1; $x <= 19; $x++): ?>
                                <div class="slide"><img src="<?= site_url('images/partners/'. $x .'.png') ?>"></div>
                                <?php endfor; ?>
                              </section>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>


                
            <!-- END PARTNERS WRAPPER -->
  		<script src="<?= site_url('front/') ?>js/common.js"></script>
        <script src="<?= site_url('front/') ?>js/jquery.prettyPhoto.js"></script>
        <script src="<?= site_url('front/') ?>js/owl.carousel.min.js"></script>
        <script src="<?= site_url('front/') ?>js/chosen.jquery.min.js"></script>
        <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
        <script src="<?= site_url('front/') ?>js/infobox.min.js"></script>

        <!-- jQuery Revolution Slider -->
        <script type="text/javascript" src="<?= site_url('front/') ?>rs-plugin/js/jquery.themepunch.tools.min.js"></script>   
        <script type="text/javascript" src="<?= site_url('front/') ?>rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

        <!-- Template Scripts -->
        <script src="<?= site_url('front/') ?>js/variables.js"></script>
        <script src="<?= site_url('front/') ?>js/scripts.js"></script>

        <!-- Agencies list -->
        <script src="<?= site_url('front/') ?>js/agencies.js"></script>
		
	
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>