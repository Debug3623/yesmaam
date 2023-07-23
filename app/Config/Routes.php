<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */


// Mobile API Routes 
$routes->group('api', function($routes){
    $routes->get('agora-token', 'Api\HomeController::getToken');
    $routes->get('agora-token-2', 'Api\HomeController::getAgoraToken');
    $routes->get('sms', 'Api\UserController::sendSMS');
    $routes->get('plans/all', 'Api\PlanController::allPlans');
    $routes->post('user/plan', 'Api\PlanController::userPlans');
    $routes->get('insurance', 'Api\PlanController::getAllInsurance');
    $routes->post('code/verification', 'Api\EmployeeController::companyVerification');
    
    $routes->post('user/delete-account', 'Api\UserController::deleteAccount');
    //$routes->group('account', function($routes){
        $routes->post('account-login', 'Api\UserController::user_login');
        $routes->post('account-register', 'Api\UserController::register');
        $routes->post('corporate-register', 'Api\CorporateUserController::corporate_register');
        $routes->post('corporate-login', 'Api\CorporateUserController::corporate_login');
        $routes->post('corporate-profile', 'Api\CorporateUserController::getCorporateProfile');
        
    $routes->group('corporate', function($routes){

        $routes->post('update-profile', 'Api\CorporateUserController::updateProfile');
        $routes->post('update/referral', 'Api\CorporateUserController::updateReferral');
        $routes->post('profile/photo/update', 'Api\CorporateUserController::updateProfilePhoto');
        $routes->post('employee/approved', 'Api\CorporateUserController::approvedEmployee');
        $routes->post('employee/approvel', 'Api\CorporateUserController::approvelEmployee');
        $routes->post('employee/unapproved', 'Api\CorporateUserController::unApprovedEmployee');
        $routes->post('employee/totalPending', 'Api\CorporateUserController::totalUnApprovedEmployee');
        $routes->post('uploadImage', 'Api\CorporateUserController::uploadImage');
        $routes->post('userPlans', 'Api\PlanController::corporateUserPlans');
        $routes->post('allFollowUp', 'Api\FollowController::allFollowUp');

    });
    
     $routes->group('employee', function($routes){
         
     $routes->post('employee-register', 'Api\EmployeeController::employee_register');
     $routes->post('profile', 'Api\EmployeeController::getEmployeeProfile');
     $routes->post('delete', 'Api\EmployeeController::deleteEmployeeAccount');
     $routes->post('statistics', 'Api\EmployeeController::getEmployeeStatistics');
     $routes->post('history', 'Api\DoctorBookingController::bookingCorporateHistory');
     $routes->post('call', 'Api\CustomerController::callEmployee');




     });
     
         $routes->group('plan', function($routes){
        // $routes->post('buy', 'Api\PlanController::buyPlan');
         $routes->post('remaining/days', 'Api\PlanController::remainingDays');
         $routes->post('buy', 'Api\PlanController::buyPlanCorporate');

         
    });
    
    
    
    //});
    $routes->group('user', function($routes){
        $routes->post('login', 'Api\UserController::login');
        
        $routes->post('resend-code', 'Api\UserController::resendVerificationCode');
        $routes->post('verify', 'Api\UserController::verifyUser');
        $routes->post('forget-password', 'Api\UserController::forget_password');
        $routes->post('change-password', 'Api\UserController::forget_password');
        $routes->post('logout', 'Api\UserController::logout');
        
        $routes->post('send-otp', 'Api\OtpController::resendOTP');
        $routes->post('verify-otp', 'Api\OtpController::verifyOTP');

        $routes->add('forget-password', 'Api\UserController::forgotPassword');
        $routes->add('change-password', 'Api\UserController::forgotPassword');

        // Delete Account
        $routes->post('delete-account', 'Api\UserController::deleteAccount');
    });

    $routes->group('customer', function($routes){
        $routes->get('doctor-bookings/(:num)', 'Api\DoctorBookingController::allBookings/$1');
        $routes->get('doctor-booking/(:num)', 'Api\DoctorBookingController::allEmployeeBookings/$1');
        $routes->post('nurse-bookings', 'Api\CustomerController::nurseBookings');
        $routes->post('update', 'Api\CustomerController::UpdateProfile/$1');
        $routes->post('update/profile-photo', 'Api\CustomerController::uploadPhoto');
        $routes->post('update/emirates', 'Api\CustomerController::uploadEmirates');
        $routes->post('update/insurance', 'Api\CustomerController::uploadInsurance');
        
        $routes->get('accepted-bids/(:num)', 'Api\CustomerController::acceptedBids/$1');
        $routes->get('appointments/(:num)', 'Api\CustomerController::appointments/$1');
        
        $routes->post('call', 'Api\CustomerController::callCustomer');
        $routes->post('followUp/call', 'Api\CustomerController::callFollowUpCustomers');
        $routes->get('insurance/status/(:num)', 'Api\CustomerController::insuranceStatus/$1');
    });

    $routes->group('category', function($routes){
        $routes->get('nurse', 'Api\CategoryController::allNurseCategories');
        $routes->post('doctor', 'Api\CategoryController::allDoctorCategories');
        $routes->get('doctors', 'Api\CategoryController::allDoctCategories');
        
        $routes->get('all', 'Api\CategoryController::allCategories');
        $routes->post('categoryWiseDoctor', 'Api\CategoryController::categoryWiseDoctor');
        $routes->get('babysitter', 'Api\CategoryController::getBabySitterCategories');
    });

    $routes->group('nurse', function($routes){
        $routes->get('/', 'Api\NurseController::allNurses');
        $routes->post('profile/edit', 'Api\NurseController::editProfile');
        $routes->post('profile/photo/update', 'Api\NurseController::updateProfilePhoto');

        $routes->post('get-nurses', 'Api\NurseController::getAllNurses');

        $routes->post('nurse-bookings', 'Api\NurseController::myBookings');
    });
    
   

    $routes->group('doctor', function($routes){
        $routes->get('/', 'Api\DoctorController::allDoctors');
        $routes->post('update-profile', 'Api\DoctorController::updateProfile');
        $routes->post('update-photo', 'Api\DoctorController::uploadPhoto');

        $routes->get('bookings/(:num)', 'Api\DoctorController::getBookings/$1');

        $routes->post('confirm-booking', 'Api\BookingController::confirmBooking');
        
        $routes->get('appointments/(:num)', 'Api\DoctorController::appointments/$1');
        $routes->post('customer/call', 'Api\DoctorController::callPatient');
        
        $routes->get('change-availability/(:num)/(:any)', 'Api\DoctorController::changeAvailability/$1/$2');
        $routes->post('change-availability', 'Api\DoctorController::changeDoctorAvailability');
        
        $routes->post('available', 'Api\DoctorController::doctorAvailable');
        $routes->get('allFollowDoctors', 'Api\FollowController::followDoctors');
        $routes->post('addFollowUp', 'Api\FollowController::addFollowUp');
        $routes->post('followupstatus', 'Api\FollowController::doctorUpdateStatus');
        $routes->post('followup', 'Api\FollowController::doctorFollowUp');
        $routes->post('prescription', 'Api\FollowController::updatePrescription');
        $routes->post('deletePrescription', 'Api\FollowController::deletePrescription');

    

    });

    $routes->group('book', function($routes){
        $routes->post('nurse', 'Api\NurseBookingController::index');
        $routes->post('doctor', 'Api\DoctorBookingController::bookDoctor');
        $routes->post('corporate', 'Api\DoctorBookingController::bookEmployee');
        
        $routes->post('nurse/available', 'Api\NurseBookingController::isNurseAvailable');
        $routes->post('doctor/available', 'Api\DoctorBookingController::isDoctorAvailable');
        
        $routes->post('status/change', 'Api\DoctorBookingController::changeStatus');
        
        $routes->post('upload-prescription', 'Api\DoctorBookingController::uploadPrescription');
        $routes->post('remove-prescription', 'Api\DoctorBookingController::removePrescription');
        $routes->post('customer/history', 'Api\DoctorBookingController::bookingCustomerHistory');
        
        

    });

    $routes->group('order', function($routes) {
        $routes->post('update', 'Api\OrderController::updateOrder');
        $routes->post('/', 'Api\OrderController::getOrders');
        $routes->post('single', 'Api\OrderController::getSingleOrder');
    });

    //$routes->resource('address', ['controller' =>'Api\AddressController']);
    $routes->group('address', function($routes){
        $routes->post('/', 'Api\AddressController::allAddresses');
        $routes->post('add', 'Api\AddressController::addAddress');
        $routes->post('delete', 'Api\AddressController::deleteAddress');
    });
    
    $routes->group('gallery', function($routes){
        $routes->get('doctor/(:num)', 'Api\GalleryController::doctorImages');
        $routes->get('nurse/(:num)', 'Api\GalleryController::nurseImages');
    });
    
    $routes->group('requirement', function($routes){
        $routes->get('/', 'Api\RequirementController::index');
        $routes->get('(:num)', 'Api\RequirementController::singleRequirement/$1');
        $routes->get('customer/(:num)', 'Api\RequirementController::customerRequirements/$1');
        $routes->post('post', 'Api\RequirementController::postRequirement');

        $routes->get('cancel', 'Api\RequirementController::cancelRequirement');
        $routes->get('confirm', 'Api\RequirementController::confirmRequirement');
        
        
    });
    
    $routes->group('bid', function($routes){
        $routes->post('/', 'Api\BidController::index');
        $routes->post('place', 'Api\BidController::placeBid');
        $routes->post('confirm', 'Api\BidController::acceptBid');
        
        $routes->get('nurse/(:num)', 'Api\BidController::nurseBids/$1');
        $routes->get('requirement/(:num)', 'Api\BidController::requirementBids/$1');
        $routes->get('cancel/(:num)', 'Api\BidController::cancelBid/$1');
    });
    
    
    $routes->group('cart', function($routes){
        $routes->get('all/(:num)', 'Api\CartController::all/$1');
        $routes->post('add', 'Api\CartController::add');
        $routes->get('remove/(:num)', 'Api\CartController::remove/$1');
        $routes->get('empty/(:num)', 'Api\CartController::empty/$1');
        $routes->post('checkout', 'Api\CartController::checkout');
    });
    
    
    $routes->group('payment', function($routes){
        $routes->get('doctor/success', 'Api\PaymentController::doctorSuccess');
        $routes->get('doctor/fail', 'Api\PaymentController::doctorFailed');
        
        $routes->get('employee/success', 'Api\PaymentController::employeeSuccess');
        $routes->get('employee/fail', 'Api\PaymentController::employeeFailed');
        
        $routes->get('plan/success', 'Api\PaymentController::planSuccess');
        //$routes->get('employee/fail', 'Api\PaymentController::employeeFailed');

        $routes->get('nurse/success', 'Api\PaymentController::nurseSuccess');
        $routes->get('nurse/fail', 'Api\PaymentController::nurseFailed');

        $routes->get('requirement/success', 'Api\PaymentController::requirementSuccess');
        $routes->get('requirement/fail', 'Api\PaymentController::requirementFailed');

        $routes->get('service/success', 'Api\PaymentController::serviceSuccess');
        $routes->get('service/fail', 'Api\PaymentController::serviceFailed');
    });

    $routes->post('contact/add', 'Api\ContactController::addEnquiry');
    
    $routes->get('banner', 'Api\BannerController::allBanners');
    $routes->get('corporate/banner', 'Api\BannerController::allCorporateBanners');
    $routes->get('notification', 'Api\BannerController::sendNotification');
    $routes->post('generate', 'Api\BannerController::generate');
});

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->add('admin/login', 'Admin\AdminController::login');
$routes->add('admin/logout', 'Admin\AdminController::logout');
$routes->add('admin/settings', 'Admin\AdminController::settings');


$routes->add('customer/login', 'Front\CustomerController::login');
$routes->add('customer/register', 'Front\CustomerController::register');
$routes->add('customer/email-verify', 'Front\CustomerController::VerifyEmail');

$routes->add('order/summary', 'Front\OrderController::summary');
$routes->get('order/success', 'Front\OrderController::success');
$routes->get('order/fail', 'Front\OrderController::failed');


$routes->add('order/doctor/summary', 'Front\OrderController::Doctorsummary');
$routes->get('payment/doctor/success', 'Front\PaymentController::doctorPaymentSuccessful');
$routes->get('payment/doctor/fail', 'Front\PaymentController::doctorPaymentFailed');
$routes->get('payment/doctor/failed', 'Front\PaymentController::doctorPaymentFailed');


$routes->get('payment/success', 'Front\PaymentController::paymentSuccessful');
$routes->get('payment/failed', 'Front\PaymentController::paymentFailed');

$routes->group('customer', ['filter' => 'CustomerAuthFilter'], function($routes){
    $routes->get('profile', 'Front\CustomerController::profile');
    $routes->add('profile/update', 'Front\CustomerController::updateProfile');
    $routes->get('bookings', 'Front\CustomerController::bookings');
    $routes->get('logout', 'Front\CustomerController::logout');
});


$routes->get('nurses', 'Front\NurseController::allNurses');
$routes->get('doctors', 'Front\DoctorController::allDoctors');
$routes->add('nurse/login', 'Front\NurseController::login');
$routes->add('nurse/register', 'Front\NurseController::register');
$routes->get('nurse/profile/(:any)', 'Front\NurseController::nurseProfile/$1');

$routes->get('doctor/profile/(:any)', 'Front\DoctorController::doctorProfile/$1');



$routes->add('nurse/book/(:any)', 'Front\BookingController::bookNurse/$1', ['filter' => 'BookingFilter']);
$routes->add('doctor/book/(:any)', 'Front\BookingController::bookDoctor/$1', ['filter' => 'DoctorBookingFilter']);

$routes->group('nurse', ['filter' => 'NurseAuthFilter'], function($routes){
    $routes->get('profile', 'Front\NurseController::profile');

    $routes->add('profile-update', 'Front\NurseController::updateProfile');

    $routes->get('bookings', 'Front\NurseController::yourBookings');
    $routes->get('logout', 'Front\NurseController::logout');
});

$routes->add('doctor/register', 'Front\DoctorController::register');


/**
 * Admin Panel Routes
 * 
 * */
$routes->get('admin/nurse/change_availibility/(:any)/(:any)', 'Admin\NurseController::changeStatus/$1/$2');
$routes->group('admin', ['filter' => 'AdminAuthFilter'], function($routes){
    $routes->get('dashboard', 'Admin\AdminController::dashboard');

    $routes->group('category', function($routes){
        $routes->get('/', 'Admin\CategoryController::index');
        $routes->post('add', 'Admin\CategoryController::addCategory');
        $routes->get('delete/(:any)', 'Admin\CategoryController::deleteCategory/$1');
    });

    $routes->group('banner', function($routes){
        $routes->get('/', 'Admin\BannerController::index');
        $routes->add('add', 'Admin\BannerController::addBanner');
        $routes->get('delete/(:any)', 'Admin\BannerController::deleteBanner/$1');
    });

    $routes->group('customer', function($routes){
        $routes->get('/', 'Admin\CustomerController::index');
        $routes->add('add', 'Admin\CustomerController::addCustomer');
        $routes->add('update/(:any)', 'Admin\CustomerController::updateCustomer/$1');
        $routes->get('delete/(:any)', 'Admin\CustomerController::deleteCustomer/$1');
        $routes->get('remove-file', 'Admin\CustomerController::removeUploadedFile');
        $routes->get('change-status/(:any)/(:num)', 'Admin\CustomerController::changeStatus/$1/$2');
    });
    $routes->add('change-doctor-for/(:any)', 'Admin\DoctorController::changeDoctorFor/$1');
    $routes->add('change-nurse-for/(:any)', 'Admin\NurseController::changeNurseFor/$1');

    $routes->group('doctor', function($routes){
        $routes->get('/', 'Admin\DoctorController::index');
        $routes->add('add', 'Admin\DoctorController::addDoctor');
        $routes->add('update/(:any)', 'Admin\DoctorController::updateDoctor/$1');
        $routes->get('delete/(:any)', 'Admin\DoctorController::deleteDoctor/$1');
      	$routes->get('confirm/(:any)', 'Admin\DoctorController::confirmDoctor/$1');

      	$routes->get('change-availibility/(:any)/(:any)', 'Admin\DoctorController::changeAvailability/$1/$2');
        
        
    });
    
        $routes->group('corporate', function($routes){
        $routes->get('/', 'Admin\CorporateController::index');
        $routes->get('employees', 'Admin\CorporateController::corporateEmployees');
        $routes->get('billing', 'Admin\CorporateController::billing');
        $routes->add('details/(:any)', 'Admin\CorporateController::singleCorporateBilling/$1');
        $routes->add('employee/update/(:any)', 'Admin\CorporateController::updateEmployee/$1');

        $routes->add('add', 'Admin\CorporateController::addCorporate');
        $routes->add('update/(:any)', 'Admin\CorporateController::updateCorporate/$1');
        $routes->get('delete/(:any)', 'Admin\CorporateController::deleteCorporate/$1');
      	$routes->get('confirm/(:any)', 'Admin\DoctorController::confirmDoctor/$1');
      	$routes->get('license/(:any)', 'Admin\CorporateController::corporateLicense/$1');
      	$routes->get('customer/(:any)', 'Admin\CorporateController::getCustomer/$1');


      	$routes->get('change-availibility/(:any)/(:any)', 'Admin\CorporateController::changeAvailability/$1/$2');
        
        
    });

    $routes->group('nurse', function($routes){
        $routes->get('/', 'Admin\NurseController::index');
        $routes->add('add', 'Admin\NurseController::addNurse');
        $routes->add('update/(:any)', 'Admin\NurseController::updateNurse/$1');
        $routes->get('delete/(:any)', 'Admin\NurseController::deleteNurse/$1');
      	$routes->get('confirm/(:any)', 'Admin\NurseController::confirmNurse/$1');
      	$routes->post('change-availibility', 'Admin\NurseController::changeAvailability');
    });
    

    $routes->group('booking', function($routes){
        $routes->get('nurses', 'Admin\BookingController::bookedNurses');
        $routes->get('doctors', 'Admin\BookingController::bookedDoctors');
        $routes->get('services', 'Admin\ServicesController::index');
            $routes->get('download/(:any)', 'Admin\BookingController::download/$1');
        $routes->post('(:any)/add-link', 'Admin\BookingController::AddLink/$1');
      	$routes->add('nurse/single/(:any)', 'Admin\BookingController::singleNurseBooking/$1');
        $routes->add('doctor/single/(:any)', 'Admin\BookingController::singleDoctorBooking/$1');
        $routes->add('service/single/(:any)', 'Admin\ServicesController::single/$1');
        $routes->get('delete/(:any)', 'Admin\BookingController::deleteBooking/$1');
        $routes->get('nurse/status/(:any)', 'Admin\BookingController::cancelBooking/$1');
        $routes->post('doctor/upload-prescription/(:any)', 'Admin\BookingController::uploadPrescription/$1');
    });

    $routes->group('requirement', function($routes){
        $routes->get('customer-requirements/(:any)', 'Admin\RequirementController::customer/$1');
        $routes->add('update/(:any)', 'Admin\RequirementController::update/$1');
        $routes->get('delete/(:any)', 'Admin\RequirementController::deleteRequirement/$1');
        
        $routes->get('bids/(:any)', 'Admin\RequirementController::bids/$1');
        $routes->get('bids/confirm/(:any)/(:any)', 'Admin\RequirementController::confirm/$1/$2');
        $routes->get('bids/cancel/(:any)', 'Admin\RequirementController::bids/$1');
    });
});



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
