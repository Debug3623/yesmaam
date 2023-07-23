<div id="nav-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <a href="https://yesmaam.ae/" class="nav-logo"><img src="<?= site_url('front/') ?>images/logo.png" alt="Yes Maam" /></a>



                <!-- BEGIN MAIN MENU -->
                <nav class="navbar">
                    <button id="nav-mobile-btn"><i class="fa fa-bars"></i></button>
                    <?php
                    $uri = service('uri');
                    $seg = $uri->getSegment(1);
                    ?>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="<?= site_url('/'); ?>">Home</a>

                        </li>
                        <!--
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" data-hover="dropdown">Service Category<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Menu 1</a></li>
                                <li><a href="#">Menu 2</a></li>

                            </ul>
                        </li>
                        -->
                      	<li class="dropdown">
                            <a href="#" data-toggle="dropdown" data-hover="dropdown">Baby Sitter<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= site_url('nurses'); ?>?location=&work_type=&category=1">Baby Sitter</a></li>
                                <li><a <?= ($seg == 'nurses') ? 'class="active"' : ''; ?> href="<?= site_url('nurses'); ?>?location=&work_type=&category=7">Home Nurse</a></li>

                            </ul>
                        </li>
                        <!--<li><a <?//= ($seg == 'nurses') ? 'class="active"' : ''; ?> href="<?//= site_url('nurses'); ?>">Book a Nurse</a></li>-->
                        <li><a <?= ($seg == 'doctors') ? 'class="active"' : ''; ?> href="<?= site_url('doctors'); ?>">Doctor on Call</a></li>
                        
                        <li><a <?= ($seg == 'contact') ? 'class="active"' : ''; ?> href="http://yesmaam.ae/contact/">Contact</a></li>
                    </ul>

                </nav>
                <!-- END MAIN MENU -->

            </div>
        </div>
    </div>
</div>