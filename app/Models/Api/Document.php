<?php

namespace App\Models\Api;



use CodeIgniter\Model;



class Document extends Model

{
    

	protected $table = 'documents';

	protected $primaryKey = 'id';

	protected $returnType = 'object';

	protected $allowedFields = ['filename', 'user_id'];

	protected $useTimestamps = false;



	public function getDocuments($user_id)
	{
		$sql = "SELECT documents.filename FROM coporate_users 
		LEFT JOIN documents ON documents.user_id = coporate_users.user_id
		WHERE documents.user_id = ?";
		$query = $this->db->query($sql, [$user_id]);
		$result = $query->getResult();
		return $result;
	}

}