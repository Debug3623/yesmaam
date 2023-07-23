<?= $this->extend('layouts/front_template.php') ?>


<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Checkout</h1>

                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>

                    <li><a href="#">Booking</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<!-- BEGIN CONTENT WRAPPER -->
<div class="container">
   <div class="row" style="margin-top: 30px; margin-bottom: 30px;">
      <div class="col-md-6 mx-auto mt-5">
         <div class="payment">
            <div class="payment_header">
               <div class="check"><</div>
            </div>
            <div class="content">
               <h1>Booking Success !</h1>
               <p>Thank you for Booking our Srvice, </p>
               <a href="<?= site_url('/') ?>">Go to Home</a>
            </div>
            
         </div>
      </div>
   </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
    
    
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<style type="text/css">
	 .payment
	{
		border:1px solid #f2f2f2;
		height:280px;
        border-radius:20px;
        background:#fff;
	}
   .payment_header
   {
	   background:rgba(255,102,0,1);
	   padding:20px;
       border-radius:20px 20px 0px 0px;
	   
   }
   
   .check
   {
	   margin:0px auto;
	   width:50px;
	   height:50px;
	   border-radius:100%;
	   background:#fff;
	   text-align:center;
   }
   
   .check i
   {
	   vertical-align:middle;
	   line-height:50px;
	   font-size:30px;
   }

    .content 
    {
        text-align:center;
    }

    .content  h1
    {
        font-size:25px;
        padding-top:25px;
    }

    .content a
    {
        width:200px;
        height:35px;
        color:#fff;
        border-radius:30px;
        padding:5px 10px;
        background:rgba(255,102,0,1);
        transition:all ease-in-out 0.3s;
    }

    .content a:hover
    {
        text-decoration:none;
        background:#000;
    }
</style>
<?= $this->endSection(); ?>