<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8" />

        <!-- Page Title -->
        <title>Yes Maam</title>

        <meta name="keywords" content="real estate, responsive, retina ready, modern html5 template, bootstrap, css3" />
        <meta name="description" content="Cozy - Responsive Real Estate HTML5 Template" />
        <meta name="author" content="Wisely Themes - www.wiselythemes.com" />

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

        <!-- Modernizr -->
        <script src="<?= site_url('front/') ?>js/modernizr-2.8.1.min.js"></script>
        <link href="<?= site_url('assets/fontawesome/css/all.min.css') ?>" rel="stylesheet" type="text/css" />
        <script src="<?= site_url('assets/js/bootbox.all.min.js') ?>"></script>
        <script src="<?= site_url('assets/js/bootbox.min.js') ?>"></script>
        <script src="<?= site_url('assets/js/bootbox.js') ?>"></script>
        
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


            <?= $this->renderSection('breadcrumbs'); ?>


            <?= $this->renderSection('content') ?>
            <!-- BEGIN FOOTER -->
            <footer id="footer">
                <div id="footer-top" class="container">
                    <div class="row">
                        <div class="block col-sm-3">
                            <!--<a href="index.html"><img src="<?= site_url('front/') ?>images/logo.png" alt="Yes Maam" /></a>
                            <br><br>-->
                          
                          <img src="<?= site_url('front/') ?>images/yesmaam_girl.png" alt="Yes Maam" /> <br/>
                           <ul class="social-networks">
                                    <li><a href="https://www.facebook.com/yesmaam.ae/"><i class="fa-brands fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/i/flow/login"><i class="fa-brands fa-twitter"></i></a></li>
                                   
                                    <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                                    <li><a href="https://www.instagram.com/yesmam.ae/"><i class="fa-brands fa-instagram"></i></a></li>
                             		<li><a href="https://www.tiktok.com/@yesmaam.ae?lang=en"><i class="fa-brands fa-tiktok"></i></a></li>
                                </ul>
                            <!--<p style="text-align:justify">Yes, Maam! provide Homecare service to your Doorstep.

                                Dubai best homecare giver service provider.

                                Services we offer from the comfort of your home like Doctor on call, PCR test, Babysitting services, Elderly care Service, Physiotherapy service, Oxygen cylinder service, School nurse, lab test a Home.

                                Our DHA-approved nurse will take complete care of your loved ones.

                            </p>-->
                        </div>
                      <div class="block col-sm-3">
                            <h3>Get in Touch with Us for the Best Quality Home care service</h3>
                        <p> Yes!maam providing health care service to your Doorstep. </p>
                        
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
                                  Office Tower, Entrance 3, Office 842
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
        <script src="<?= site_url('front/'); ?>js/common.js"></script>
        <script src="<?= site_url('front/'); ?>js/chosen.jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
        <!-- Template Scripts -->
        <script src="<?= site_url('front/'); ?>js/variables.js"></script>
        <script src="<?= site_url('front/'); ?>js/scripts.js"></script>
        <script src="<?= site_url('assets/fontawesome/js/all.min.js') ?>"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script type="text/javascript">
            $(document).ready(function(){
              $('.customer-logos').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1000,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [{
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 4
                  }
                }, {
                  breakpoint: 520,
                  settings: {
                    slidesToShow: 3
                  }
                }]
              });
            });
        </script>
        <?= $this->renderSection('script'); ?>
    </body>
</html>