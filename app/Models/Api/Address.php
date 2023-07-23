<?php
namespace App\Models\Api;

use CodeIgniter\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['customer_id', 'address_name', 'city', 'pincode', 'status'];
    protected $useTimestamps = true;
}
