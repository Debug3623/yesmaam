<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class FollowDoctors extends Model
{
	protected $table = 'follow_doctors';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['user_id'];
	protected $useTimestamps = false;
}
