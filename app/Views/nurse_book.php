<?= $this->extend('layouts/front_template.php') ?>


<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Book a Nurse</h1>

                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>

                    <li><a href="#">Booking Form</a></li>
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
            <div class="main col-sm-12">

                <div class="login col-sm-5 col-sm-offset-1">
                    <h1 class="center">Book Service</h1>

                    <div class="col-sm-12">
                        <form class="form-style" method="post" action="<?= site_url('nurse/book/' . EncryptId($nurse->id)) ?>">

                            <?php if($msg): ?>
                            <div class="alert alert-success"><?= $msg ?></div>
                            <?php endif; ?>

                            <?php if(isset($validator)): ?>
                            <div class="alert alert-danger"><?= $validator->listErrors(); ?></div>
                            <?php endif; ?>
                           
                            <label for="service_for"> Service Booked for? (Hourly/Weekly/Monthly) </label>   
                            <?php if(isset($validator) && $validator->hasError('service_for')): ?>
                            <div class="alert alert-danger">
                                <?= $validator->getError('service_for'); ?>
                            </div>
                            <?php endif; ?> 
                            <select class="form-control" name="service_for" id="service_for">
                                <option></option>
                                <option value="Hourly">Hourly</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                            </select>


                            


                           
                            
                            
                            
                            <div id="pg">
                            <div id="fu"></div>
                            <div id="to"></div>
                            </div>
                            <button type="submit" class="btn btn-fullcolor">Book Now</button>
                            
                        </form>
                        
                        
                    </div>


                </div>

                <div class="login-info col-sm-4 col-sm-offset-1">
                    <h1>Book Nurse</h1>
                    
                    <p><img src="<?= site_url('front/') ?>images/book nurse.jpg" class="img-responsive" ></p>
                </div>
            </div>  
            <!-- END MAIN CONTENT -->

        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#service_for').change(function(){
            var obj = $(this);
            var hel = '<label for="service_date"> Service Date</label> <input type="date" id="service_date" name="service_date" placeholder="Service Date" class="form-control" min="<?= date('Y-m-d') ?>" /> <label for="service_time"> Service time </label> <input type="time" id="service_time" name="service_time" placeholder="Address" class="form-control" /><label for="hours"> No of Hours </label>  <select class="form-control" name="hours" id="hours"> <option></option> <?php for($x=1; $x<=8; $x++): ?> <option value="<?= $x ?>"><?= $x ?></option> <?php endfor; ?> </select>';

            var week = '<label for="week">Choose a week:</label><input type="week" name="week" id="camp-week" required class="form-control">';
            // min="2018-W18" max="2018-W26"

            var month = '<label for="camp-month">Choose a Month:</label><input type="month" name="month" id="camp-month" required class="form-control">';

            if(obj.val() == 'Hourly') {
                $('#pg').empty();
                //$(hel).insertAfter("#fu");
                $('#pg').html(hel);
            }
            else if(obj.val() == 'Weekly') {
                $('#pg').empty();
                //$(week).insertAfter("#fu");
                $('#pg').html(week);
            }
            else if(obj.val() == 'Monthly') {
                $('#pg').empty();
                //$(month).insertAfter("#fu");
                $('#pg').html(month);
            }
        });

        
    });
</script>
<?= $this->endSection(); ?>