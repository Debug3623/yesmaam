<?php
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class BookingController extends ResourceController
{
    protected $modelName = 'App\Models\Api\NurseBook';
    protected $format = 'json';

    
}