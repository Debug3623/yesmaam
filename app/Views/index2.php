<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8" />

        <!-- Page Title -->
        <title>Yes Maam</title>

        <meta name="keywords" content="Yes Maam" />
        <meta name="description" content="Yes Maam" />
        <meta name="author" content="Yes Maam" />

        <!-- Mobile Meta Tag -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

        <!-- Fav and touch icons -->
        <link rel="shortcut icon" type="image/x-icon" href="<?= site_url('front/') ?>images/logo.png" />
        <link rel="apple-touch-icon" href="<?= site_url('front/') ?>images/logo.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?= site_url('front/') ?>images/logo.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?= site_url('front/') ?>images/logo.png" />

        <!-- IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> 
        <![endif]-->

        <!-- Google Web Font -->
        <link href="http://fonts.googleapis.com/css?family=Raleway:300,500,900%7COpen+Sans:400,700,400italic" rel="stylesheet" type="text/css" />

        <!-- Bootstrap CSS -->
        <link href="<?= site_url('front/') ?>css/bootstrap.min.css" rel="stylesheet" />

        <!-- Template CSS -->
        <link href="<?= site_url('front/') ?>css/style.css" rel="stylesheet" />
        <!-- Revolution Slider CSS settings -->
        <link rel="stylesheet" type="text/css" href="<?= site_url('front/') ?>rs-plugin/css/settings.css" media="screen" />
        <!-- Modernizr -->
        <script src="<?= site_url('front/') ?>js/modernizr-2.8.1.min.js"></script>
    </head>
    <body>
        <!-- BEGIN WRAPPER -->
        <div id="wrapper">

            <!-- BEGIN HEADER -->
            <header id="header">
                <div id="top-bar">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul id="top-info">
                                    <li>Call:  +971589261206</li>
                                    <li>Email: <a href="mailto:admin@yesmaam.ae">admin@yesmaam.ae</a></li>
                                </ul>

                                <ul id="top-buttons">
                                    <?php  
                                        $nurse = session()->get('nurse');
                                        $customer = session()->get('customer');

                                        if($nurse) {
                                    ?>
                                        <li><a href="<?= site_url('nurse/profile') ?>"><i class="fa fa-sign-in"></i> Nurse Profile</a></li>

                                        <li><a href="<?= site_url('nurse/logout') ?>" class="text-danger"><i class="fa fa-sign-in"></i> Logout</a></li>

                                    <?php
                                        }
                                        else if($customer) {
                                    ?>
                                        <li><a href="<?= site_url('customer/profile') ?>"><i class="fa fa-sign-in"></i> Customer Profile</a></li>

                                        <li><a href="<?= site_url('customer/logout') ?>" class="text-danger"><i class="fa fa-sign-in"></i>  Logout</a></li>
                                    <?php
                                        }
                                        else {
                                    ?>
                                    <li><a href="<?= site_url('customer/login') ?>"><i class="fa fa-sign-in"></i> Customer Login</a></li>
                                    <li><a href="<?= site_url('nurse/login') ?>"><i class="fa fa-sign-in"></i> Nurse Login</a></li>
                                    <li>
                                        <div class="language-switcher">
                                            <span><i class="fa fa-user"></i> Create Account</span>
                                            <ul>
                                                <li><a href="<?= site_url('customer/register') ?>">Customer </a></li>
                                                <li><a href="<?= site_url('nurse/register') ?>">Nurse </a></li>
                                                <li><a href="<?= site_url('doctor/register') ?>">Doctor </a></li>

                                            </ul>
                                        </div>
                                    </li> 
                                    <?php
                                        }
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <?= $this->include('partials/front/menubar.php') ?>
            </header>
            <!-- END HEADER -->


            <!-- BEGIN HOME SEARCH SECTION -->
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
            <!-- END HOME SEARCH SECTION -->



            <!-- BEGIN PROPERTIES SLIDER WRAPPER-->
            <div class="parallax pattern-bg" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">Homecare Service</h1>

                            <div id="featured-properties-slider" class="owl-carousel fullwidthsingle" data-animation-direction="from-bottom" data-animation-delay="250">
                                <div class="item">
                                    <div class="image">
                                        <a href="#"></a>
                                        <img src="<?= site_url('front/') ?>images/nurse-feature.jpg" alt="" />
                                    </div>

                                    <div class="info">
                                        <h3><a href="">Book Your Nurse</a></h3>
                                        <p>Baby sitting, Home Nursing, PCR Swab test,Doctor On call, Lab test, Physiotherapy service to your Doorstep. </p>
                                        <a href="#" class="btn btn-default">Read More</a>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="image">
                                        <a href="#"></a>
                                        <img src="<?= site_url('front/') ?>images/telemedicine.jpg" alt="" />
                                    </div>

                                    <div class="info">
                                        <h3><a href="">Doctor On Call</a></h3>
                                        <p>Hire your doctor and fix the video for consulting </p>
                                        <a href="#" class="btn btn-default">Read More</a>
                                    </div>
                                </div>




                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROPERTIES SLIDER WRAPPER -->

            <!-- BEGIN CONTENT WRAPPER -->
            <div class="content">
                <div class="container">
                    <div class="row">

                        <!-- BEGIN MAIN CONTENT -->
                        <div class="main col-sm-12">
                            <h1 class="section-title">Book Your Nurse</h1>

                            <div class="grid-style1 clearfix">
                                

                                <?php foreach($nurses as $nurse): ?>
                                <div class="item col-md-3" >
                                    <div class="image">
                                        <a href="<?= site_url('nurse/profile/' . EncryptId($nurse->id)) ?>">
                                            <h3><?= $nurse->first_name . ' ' . $nurse->last_name ?></h3>
                                            <span class="location"><?= $nurse->city ?></span>
                                        </a>
                                        <img src="<?= site_url($nurse->photo) ?>" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                   
                                    <ul class="amenities">
                                      
                                   		<li style="border:none;"> <h4><?= $nurse->first_name . ' ' . $nurse->last_name ?></h4> </li>   
                                       <!--<li> <h6>Expertise: <?//= $nurse->expertise; ?> </h6> </li>-->
                                       <li style="border:none;"> <h6>Skill: <?= $nurse->skills; ?> </h6> </li>
                                       <br/><br/>
                                       <li> <a href="<?= site_url('nurse/profile/' . EncryptId($nurse->id)) ?>" ><b>View Profile</b></a></li>

                                    </ul>
                                </div>

                                <?php endforeach; ?>


                                

                            </div>




                            <h1 class="section-title">Doctor On Call</h1>
                            <div class="grid-style1">

                                <?php foreach($doctors as $doc): ?>
                                <div class="item col-md-3">
                                    <div class="image">
                                        <a href="<?= site_url('doctor/profile/' . EncryptId($doc->id)); ?>">
                                            <h3><?= $doc->first_name . ' ' . $doc->last_name ?></h3>
                                            <span class="location"><?= $doc->city; ?></span>
                                        </a>
                                        <img src="<?= site_url($doc->photo) ?>" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                      
                                      
                                      	<li style="border:none;"> <h4><?= $doc->first_name . ' ' . $doc->last_name ?></h4> </li>   
                                        <!--<li> <h6>Expertise: <?//= $nurse->expertise; ?> </h6> </li>-->
                                        <li style="border:none;"> <h6>Specialities: <?= $doc->specialities; ?> </h6> </li>
                                        <li style="border:none;"> <h6>License: DHA </h6> </li>
                                        <br/><br/>
                                        <li class=""> <a href="<?= site_url('doctor/profile/' . EncryptId($doc->id)); ?>"><b>View Profile</b></a>


                                        </li>
                                      

                                    </ul>

                                </div>
                                
                                <?php endforeach; ?>

                                
                            </div>


                        </div>
                        <!-- END MAIN CONTENT -->

                        

                    </div>
                </div>
            </div>
            <!-- END CONTENT WRAPPER -->

            <!-- BEGIN PARTNERS WRAPPER -->
            <div class="parallax pattern-bg" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="section-title">Our Partners</h1>

                            <div id="partners">
                                <div class="item">
                                    <a href="#"><img src="<?= site_url('front/') ?>images/Partner/1.png" alt="" onmouseover="this.src = '<?= site_url('front/') ?>images/Partner/1.png';" onmouseout="this.src = '<?= site_url('front/') ?>images/Partner/1.png';" /></a>
                                </div>
                                <div class="item">
                                    <a href="#"><img src="<?= site_url('front/') ?>images/Partner/2.png" alt="" onmouseover="this.src = '<?= site_url('front/') ?>images/Partner/2.png';" onmouseout="this.src = '<?= site_url('front/') ?>images/Partner/2.png';" /></a>
                                </div>
                                <div class="item">
                                    <a href="#"><img src="<?= site_url('front/') ?>images/Partner/3.png" alt="" onmouseover="this.src = 'images/Partner/3.png';" onmouseout="this.src = '<?= site_url('front/') ?>images/Partner/3.png';" /></a>
                                </div>
                                <div class="item">
                                    <a href="#"><img src="<?= site_url('front/') ?>images/Partner/4.png" alt="" onmouseover="this.src = '<?= site_url('front/') ?>images/Partner/4.png';" onmouseout="this.src = '<?= site_url('front/') ?>images/Partner/4.png';" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PARTNERS WRAPPER -->

            <!-- BEGIN FOOTER -->
            <footer id="footer">
                <div id="footer-top" class="container">
                    <div class="row">
                        <div class="block col-sm-3">
                            <!--<a href="index.html"><img src="<?= site_url('front/') ?>images/logo.png" alt="Yes Maam" /></a>
                            <br><br>-->
                          
                          <img src="<?= site_url('front/') ?>images/yesmaam_girl.png" alt="Yes Maam" /> <br/>
                           <ul class="social-networks">
                             		
                             
                             
                                    <li><a href="https://www.facebook.com/yesmaam.ae/"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/i/flow/login"><i class="fa fa-twitter"></i></a></li>
                                   
                                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                                    <li><a href="https://www.instagram.com/yesmam.ae/"><i class="fa fa-instagram"></i></a></li>
                             		<!-- <li><a href="https://www.tiktok.com/@yesmaam.ae?lang=en"><i class="fa fa-tiktok"></i></a></li> -->
                                </ul>
                            <!--<p style="text-align:justify">Yes, Maam! provide Homecare service to your Doorstep.

                                Dubai best homecare giver service provider.

                                Services we offer from the comfort of your home like Doctor on call, PCR test, Babysitting services, Elderly care Service, Physiotherapy service, Oxygen cylinder service, School nurse, lab test a Home.

                                Our DHA-approved nurse will take complete care of your loved ones.

                            </p>-->
                        </div>
                      <div class="block col-sm-3">
                            <h3>Get in Touch with Us for the Best Quality Home care service</h3>
                        <p> Yes Maam! providing health care service to your Doorstep. </p>
                        
                        <ul class="footer-links">
                                <li><a href="https://yesmaam.ae/pcr-test-dubai/">PCR Test at Home Dubai</a></li>
                                <li><a href="https://yesmaam.ae/babysitting-service/">Babysitting Services In Dubai</a></li>
                                <li><a href="https://yesmaam.ae/physiotherapy-services/">Best Physiotherapy In Dubai </a></li>
                          <li><a href="https://yesmaam.ae/lab-at-home-service/">Lab Tests at Home in Dubai </a></li>
                          <li><a href="https://yesmaam.ae/elderly-care-services-dubai/">Elderly Care at Home in Dubai </a></li>
                          <li><a href="https://yesmaam.ae/sitemap/">Sitemap </a></li>
                          

                            </ul>
                        
                        
                        
                        </div>
                        <div class="block col-sm-3">
                            <h3>Contact Us</h3>
                            <ul class="footer-contacts">
                                <li><i class="fa fa-map-marker"></i> Al Ghurair Centre,
                                  Al Rigga Road, Deira
                                  Office Tower, Entrance 3,
                                  Dubai, 25570
                                  UAE</li>
                                <li><i class="fa fa-phone"></i>Call or Whatsapp: +971589261206</li>
                                <li><i class="fa fa-envelope"></i> <a href="mailto:admin@yesmaam.ae">admin@yesmaam.ae</a></li>
                            </ul>
                        </div>
                        <div class="block col-sm-3">
                            <h3>Important Links</h3>
                            <ul class="footer-links">
                                <li><a href="https://yesmaam.ae/privacy_policy/">Privacy Policy</a></li>
                              	<li><a href="#">Shipping Details</a></li>  
                              <li><a href="#">Terms & Condition</a></li>
                                

                            </ul>
                        </div>
                        

                    </div>
                </div>


                <!-- BEGIN COPYRIGHT -->
                <div id="copyright">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                All rights reserved.

                                <!-- BEGIN SOCIAL NETWORKS 
                                <ul class="social-networks">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                                    <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                </ul>-->
                                <!-- END SOCIAL NETWORKS -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- END COPYRIGHT -->

            </footer>
            <!-- END FOOTER -->

        </div>
        <!-- END WRAPPER -->


        <!-- Libs -->
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

        <script type="text/javascript">
                                        (function ($) {
                                            "use strict";

                                            $(document).ready(function () {
                                                //Create agencies map with markers and populate dropdown agencies list.
                                                Cozy.agencyMap(agencies, "map_agency");
                                            });
                                        })(jQuery);
        </script>
    </body>
</html>