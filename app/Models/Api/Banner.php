<?php
namespace App\Models\Api;

use CodeIgniter\Model;

Class Banner extends Model
{
    protected $table = "banners";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $allowedFields = [
        'image', 'href', 'status'
    ];
    protected $useTimestamps = false;
}