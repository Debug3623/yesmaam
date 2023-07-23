<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
      	<style>
      		.gradient-custom-2 {
              /* fallback for old browsers */
              background: #a1c4fd;

              /* Chrome 10-25, Safari 5.1-6 */
              background: -webkit-linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1));

              /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
              background: linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1))
            }

            #progressbar-1 {
              color: #455A64;
            }

            #progressbar-1 li {
              list-style-type: none;
              font-size: 13px;
              width: 33.33%;
              float: left;
              position: relative;
            }

            #progressbar-1 #step1:before {
              content: "1";
              color: #fff;
              width: 29px;
              margin-left: 22px;
              padding-left: 11px;
            }

            #progressbar-1 #step2:before {
              content: "2";
              color: #fff;
              width: 29px;
            }

            #progressbar-1 #step3:before {
              content: "3";
              color: #fff;
              width: 29px;
              margin-right: 22px;
              text-align: center;
            }

            #progressbar-1 li:before {
              line-height: 29px;
              display: block;
              font-size: 12px;
              background: #455A64;
              border-radius: 50%;
              margin: auto;
            }

            #progressbar-1 li:after {
              content: '';
              width: 121%;
              height: 2px;
              background: #455A64;
              position: absolute;
              left: 0%;
              right: 0%;
              top: 15px;
              z-index: -1;
            }

            #progressbar-1 li:nth-child(2):after {
              left: 50%
            }

            #progressbar-1 li:nth-child(1):after {
              left: 25%;
              width: 121%
            }

            #progressbar-1 li:nth-child(3):after {
              left: 25%;
              width: 50%;
            }

            #progressbar-1 li.active:before,
            #progressbar-1 li.active:after {
              background: #1266f1;
            }

            .card-stepper {
              z-index: 0
            }
      	</style>	
    </head>
    <body>
        <section class="vh-100 gradient-custom-2">
            <div class="container py-5 h-100">
              	
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-10 col-lg-8 col-xl-6">
                      	<img src="<?= site_url('images/yesmaam logo small.png') ?>" style="display: block; margin:0 auto; width: 40%" />
                        <div class="card card-stepper" style="border-radius: 16px;">
                            <div class="card-header p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-2"> Order ID <span class="fw-bold text-body"><?= $order->order_id ?></span></p>
                                        <p class="text-muted mb-0"> Place On <span class="fw-bold text-body"><?= $order->order_date ?></span> </p>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex flex-row mb-4 pb-2">
                                    <div class="flex-fill">
                                        <h5 class="bold"><?= $item->first_name . ' ' . $item->last_name; ?></h5>
                                        <h4 class="mb-3"> AEU <?= $order->amount; ?> <span class="small text-muted"> via (<?= $order->payment_type; ?>) </span></h4>
                                        <p class="text-muted">Date Booked For: <span class="text-body"><?= date('d,M') ?></span></p>
                                    </div>
                                    <div>
                                      
                                        <img class="align-self-center img-fluid" src="<?= site_url($item->photo) ?>" width="250">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-footer p-4">
                                <div class="d-flex justify-content-between">
                                  	<div>Visit us: <a href="https://nurse.yesmaam.ae/public/" target="_blank">YesMaam</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      
      
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>