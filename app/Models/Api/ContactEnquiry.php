<?php
namespace App\Models\Api;

use CodeIgniter\Model;

class ContactEnquiry extends Model
{
    protected $table = 'contact_enquiries';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['name', 'email', 'phone', 'category', 'message', 'status'];
	protected $useTimestamps = true;
}