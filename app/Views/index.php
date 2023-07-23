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
                                    <li>Call:  +97142399313</li>
                                    <li>Email: <a href="mailto:support@yesmaam.ae">support@yesmaam.ae</a></li>
                                </ul>

                                <ul id="top-buttons">
                                    <li><a href="customer-login.html"><i class="fa fa-sign-in"></i> Customer Login</a></li>
                                    <li><a href="nurse-login.html"><i class="fa fa-sign-in"></i> Nurse Login</a></li>

                                    <li>
                                        <div class="language-switcher">
                                            <span><i class="fa fa-user"></i> Create Account</span>
                                            <ul>
                                                <li><a href="customer-register.html">Customer </a></li>
                                                <li><a href="nurse-register.html">Nurse </a></li>
                                                <li><a href="doctor-register.html">Doctor </a></li>
                                                 
                                            </ul>
                                        </div>
                                    </li> 

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="nav-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="index.html" class="nav-logo"><img src="<?= site_url('front/') ?>images/logo.png" alt="Yes Maam" /></a>



                                <!-- BEGIN MAIN MENU -->
                                <nav class="navbar">
                                    <button id="nav-mobile-btn"><i class="fa fa-bars"></i></button>

                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="active" href="#" data-toggle="dropdown" data-hover="dropdown">Home</a>

                                        </li>

                                        <li class="dropdown">
                                            <a href="#" data-toggle="dropdown" data-hover="dropdown">Service Category<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Menu 1</a></li>
                                                <li><a href="#">Menu 2</a></li>

                                            </ul>
                                        </li>

                                        <li><a href="#">Contact</a></li>
                                    </ul>

                                </nav>
                                <!-- END MAIN MENU -->

                            </div>
                        </div>
                    </div>
                </div>
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
                            <a href="#" class="caption sfb btn btn-default btn-lg" data-x="75" data-y="260" data-speed="800" data-easing="easeOutBack" data-start="1600" data-end="9800" data-endspeed="500" data-endeasing="easeInSine">Book Now</a>
                        </li>

                        <li data-transition="fade">
                            <img src="<?= site_url('front/') ?>images/Slide_Doctor.jpg" alt="" />
                            <div class="caption sfr slider-title" data-x="450" data-y="120" data-speed="800" data-start="1300" data-easing="easeOutBack" data-end="9600" data-endspeed="500" data-endeasing="easeInSine">Doctor on Call</div>
                            <div class="caption sfl slider-subtitle" data-x="455" data-y="190" data-speed="800" data-start="1500" data-easing="easeOutBack" data-end="9700" data-endspeed="500" data-endeasing="easeInSine">Best Service for Doctor on Call</div>
                            <a href="#" class="caption sfb btn btn-default btn-lg" data-x="455" data-y="310" data-speed="800" data-easing="easeOutBack" data-start="1600" data-end="9800" data-endspeed="500" data-endeasing="easeInSine">Book Now</a>
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
                        <div class="main col-sm-8">
                            <h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">Book Your Nurse</h1>

                            <div class="grid-style1 clearfix">
                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="properties-detail.html">
                                            <h3>Name of Nurse</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/nurse.png" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                        <li> <a href="booking-form.html"> Book Now </a></li>
                                        <li> <a href="nurse-profile-view.html">View Profile</a></li>

                                    </ul>
                                </div>

                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="properties-detail.html">
                                            <h3>Name of Nurse</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/nurse1.png" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                    <li> <a href="booking-form.html"> Book Now </a></li>
                                        <li> <a href="nurse-profile-view.html">View Profile</a></li>

                                    </ul>
                                </div>

                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="properties-detail.html">
                                            <h3>Name of Nurse</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/nurse.png" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                       <li> <a href="booking-form.html"> Book Now </a></li>
                                        <li> <a href="nurse-profile-view.html">View Profile</a></li>

                                    </ul>
                                </div>

                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="properties-detail.html">
                                            <h3>Name of Nurse</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/nurse1.png" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                       <li> <a href="booking-form.html"> Book Now </a></li>
                                        <li> <a href="nurse-profile-view.html">View Profile</a></li>

                                    </ul>
                                </div>

                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="properties-detail.html">
                                            <h3>Name of Nurse</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/nurse.png" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                      <li> <a href="booking-form.html"> Book Now </a></li>
                                        <li> <a href="nurse-profile-view.html">View Profile</a></li>

                                    </ul>
                                </div>
                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="properties-detail.html">
                                            <h3>Name of Nurse</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/nurse1.png" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                       <li> <a href="booking-form.html"> Book Now </a></li>
                                        <li> <a href="nurse-profile-view.html">View Profile</a></li>

                                    </ul>
                                </div>


                                <div class="center"><a href="#" class="btn btn-default-color" data-animation-direction="from-bottom" data-animation-delay="850">View All Nurses</a></div>

                            </div>




                            <h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">Doctor On Call</h1>
                            <div class="grid-style1">
                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="#">
                                            <h3>Name of Doctor</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/Dr.-Rajanikant-N.-Shah-1.jpg" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                        <li> <a href="#"> Book Now </a></li>
                                        <li> <a href="#">View Profile</a></li>

                                    </ul>
                                </div>
                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="#">
                                            <h3>Name of Doctor</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/Dr.-Sheeza-Ali-1.jpg" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                        <li> <a href="#"> Book Now </a></li>
                                        <li> <a href="#">View Profile</a></li>

                                    </ul>
                                </div>
                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="#">
                                            <h3>Name of Doctor</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/Dr.-Rajanikant-N.-Shah-1.jpg" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                        <li> <a href="#"> Book Now </a></li>
                                        <li> <a href="#">View Profile</a></li>

                                    </ul>
                                </div>
                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="#">
                                            <h3>Name of Doctor</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/Dr.-Sheeza-Ali-1.jpg" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                        <li> <a href="#"> Book Now </a></li>
                                        <li> <a href="#">View Profile</a></li>

                                    </ul>
                                </div>
                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="#">
                                            <h3>Name of Doctor</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/Dr.-Rajanikant-N.-Shah-1.jpg" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                        <li> <a href="#"> Book Now </a></li>
                                        <li> <a href="#">View Profile</a></li>

                                    </ul>
                                </div>
                                <div class="item col-md-4" data-animation-direction="from-bottom" data-animation-delay="200">
                                    <div class="image">
                                        <a href="#">
                                            <h3>Name of Doctor</h3>
                                            <span class="location">Address</span>
                                        </a>
                                        <img src="<?= site_url('front/') ?>images/Dr.-Sheeza-Ali-1.jpg" alt="" />
                                    </div>
                                    <div class="price">

                                        <span>Book Now</span>
                                    </div>
                                    <ul class="amenities">
                                        <li> <a href="#"> Book Now </a></li>
                                        <li> <a href="#">View Profile</a></li>

                                    </ul>
                                </div>

                                <div class="center"><a href="#" class="btn btn-default-color" data-animation-direction="from-bottom" data-animation-delay="850">View All Doctors</a></div>
                            </div>


                        </div>
                        <!-- END MAIN CONTENT -->

                        <!-- BEGIN SIDEBAR -->
                        <div class="sidebar col-sm-4">

                            <!-- BEGIN SIDEBAR ABOUT -->
                            <div class="col-sm-12">
                                <h2 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">About Us</h2>
                                <p class="center" data-animation-direction="from-bottom" data-animation-delay="200">
                                    Aliquam faucibus elit sed tempus molestie, aenean sodales venenatis. 
                                    <strong>Vestibulum pulvinar</strong> arcu suscipit, volutpat velit nec, euismod nibh vestibulum ut 
                                    sodales lacus, eget mattis arcu. Curabitur quis augue magna.

                                </p>
                            </div>
                            <!-- END SIDEBAR ABOUT -->

                            <!-- BEGIN SIDEBAR AGENTS -->
                            <div class="col-sm-12">
                                <h2 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">Our Process</h2>
                                <ul class="agency-detail-agents">
                                    <li class="col-lg-12" data-animation-direction="from-bottom" data-animation-delay="200">
                                        <a href="agent-detail.html"><img src="http://placehold.it/307x307" alt="" /></a>
                                        <div class="info">
                                            <a href="agent-detail.html"><h3>John Doe</h3></a>
                                            <span class="location">Manhattan, New York</span>
                                            <p>Curabitur quis augue magna volutpat velit nec, euismod nibh vestibulum.</p>
                                            <a href="agent-detail.html">Learn More &raquo;</a>
                                        </div>
                                    </li>
                                    <li class="col-lg-12" data-animation-direction="from-bottom" data-animation-delay="400">
                                        <a href="agent-detail.html"><img src="http://placehold.it/307x307" alt="" /></a>
                                        <div class="info">
                                            <a href="agent-detail.html"><h3>Mary Ipsum Dolor</h3></a>
                                            <span class="location">Miami, Florida</span>
                                            <p>Curabitur quis augue magna volutpat velit nec, euismod nibh vestibulum.</p>
                                            <a href="agent-detail.html">Learn More &raquo;</a>
                                        </div>
                                    </li>
                                    <li class="col-lg-12" data-animation-direction="from-bottom" data-animation-delay="600">
                                        <a href="agent-detail.html"><img src="http://placehold.it/307x307" alt="" /></a>
                                        <div class="info">
                                            <a href="agent-detail.html"><h3>Sarah Donec</h3></a>
                                            <span class="location">Beverly Hills, California</span>
                                            <p>Curabitur quis augue magna volutpat velit nec, euismod nibh vestibulum.</p>
                                            <a href="agent-detail.html">Learn More &raquo;</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- END SIDEBAR AGENTS -->

                            <!-- BEGIN AGENCIES -->

                            <!-- END AGENCIES -->

                        </div>
                        <!-- END SIDEBAR -->

                    </div>
                </div>
            </div>
            <!-- END CONTENT WRAPPER -->

            <!-- BEGIN PARTNERS WRAPPER -->
            <div class="parallax pattern-bg" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50">Our Partners</h1>

                            <div id="partners">
                                <div class="item" data-animation-direction="from-bottom" data-animation-delay="250">
                                    <a href="#"><img src="<?= site_url('front/') ?>images/Partner/1.png" alt="" onmouseover="this.src = 'images/Partner/1.png';" onmouseout="this.src = 'images/Partner/1.png';" /></a>
                                </div>
                                <div class="item" data-animation-direction="from-bottom" data-animation-delay="450">
                                    <a href="#"><img src="<?= site_url('front/') ?>images/Partner/2.png" alt="" onmouseover="this.src = 'images/Partner/2.png';" onmouseout="this.src = 'images/Partner/2.png';" /></a>
                                </div>
                                <div class="item" data-animation-direction="from-bottom" data-animation-delay="650">
                                    <a href="#"><img src="<?= site_url('front/') ?>images/Partner/3.png" alt="" onmouseover="this.src = 'images/Partner/3.png';" onmouseout="this.src = 'images/Partner/3.png';" /></a>
                                </div>
                                <div class="item" data-animation-direction="from-bottom" data-animation-delay="850">
                                    <a href="#"><img src="<?= site_url('front/') ?>images/Partner/4.png" alt="" onmouseover="this.src = 'images/Partner/4.png';" onmouseout="this.src = 'images/Partner/4.png';" /></a>
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
                            <a href="index.html"><img src="<?= site_url('front/') ?>images/logo.png" alt="Yes Maam" /></a>
                            <br><br>
                            <p>Yes, Maam! provide Homecare service to your Doorstep.

                                Duabi best homecare giver service provider.

                                Services we offer from the comfort of your home like Doctor on call, PCR test, Babysitting services, Elderly care Service, Physiotherapy service, Oxygen cylinder service, School nurse, lab test a Home.

                                Our DHA-approved nurse will take complete care of your loved ones.

                            </p>
                        </div>
                        <div class="block col-sm-3">
                            <h3>Contact Info</h3>
                            <ul class="footer-contacts">
                                <li><i class="fa fa-map-marker"></i> 609, almoosa tower, Sheikh Zayed Road, Dubai</li>
                                <li><i class="fa fa-phone"></i>971 58 926 1206 / 971 4 566 3602</li>
                                <li><i class="fa fa-envelope"></i> <a href="mailto:admin@yesmaam.ae">admin@yesmaam.ae</a></li>
                            </ul>
                        </div>
                        <div class="block col-sm-3">
                            <h3>Helpful Links</h3>
                            <ul class="footer-links">
                                <li><a href="#">Link 1</a></li>
                                <li><a href="#">Link 2</a></li>
                                <li><a href="#">Link 3</a></li>

                            </ul>
                        </div>
                        <div class="block col-sm-3">
                            <img src="<?= site_url('front/') ?>images/yesmaam_girl.png" alt="Yes Maam" />
                        </div>

                    </div>
                </div>


                <!-- BEGIN COPYRIGHT -->
                <div id="copyright">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                All rights reserved.

                                <!-- BEGIN SOCIAL NETWORKS -->
                                <ul class="social-networks">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                                    <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                </ul>
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