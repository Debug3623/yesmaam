<?php
namespace App\Models\Api;

use CodeIgniter\Model;

Class CorporateBanner extends Model
{
    protected $table = "corporate_banners";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $allowedFields = [
        'image', 'href', 'status'
    ];
    protected $useTimestamps = false;
}