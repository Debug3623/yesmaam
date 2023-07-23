<?php

namespace App\Models\Api;



use CodeIgniter\Model;



Class Bid extends Model

{

    protected $table = 'bids';

    protected $primaryKey = 'id';

    protected $returnType = 'object';

    protected $allowedFields = [

        'nurse_id', 'requirement_id', 'price', 'message', 'status'

    ];

    protected $useTimestamps = true;

    

    public function nurseBids($nurse_id)

    {

        $sql = "SELECT bids.*, nurses.first_name AS nurse_fname, nurses.last_name AS nurse_lname FROM bids LEFT JOIN nurses ON nurses.id = bids.nurse_id WHERE bids.nurse_id = ?";

        $query = $this->query($sql, [$nurse_id]);

        $result = $query->getResult();

        

        $data = [];

        foreach($result as $row) {

            $sql = "SELECT requirements.*, customers.first_name AS cus_fname, customers.last_name AS cus_lname FROM requirements LEFT JOIN customers ON customers.id = requirements.user_id LEFT JOIN bids ON bids.requirement_id = requirements.id WHERE bids.id = ? AND bids.status !=2";

            $query = $this->db->query($sql, [$row->id]);

            $row->other = $query->getResult();

            $data[] = $row;

        }

        return $data;

    }

    

    public function getAllBids($req_id) {

        $sql = "SELECT bids.*, 
       nurses.user_id, nurses.first_name AS nurse_fname, nurses.last_name AS nurse_lname, nurses.email, nurses.phone, nurses.work_title, nurses.about, nurses.expertise, nurses.category, nurses.working_hours, nurses.date_of_birth, nurses.marital_status, nurses.skills, nurses.visa_type, nurses.photo, nurses.working_type, nurses.nationality, nurses.experience, nurses.city, nurses.address, nurses.EID, nurses.passport_no,nurses. passport, nurses.confirmed, nurses.status, nurses.speaking_languages,
       main_categories.name AS cate_name FROM bids LEFT JOIN nurses ON nurses.id = bids.nurse_id LEFT JOIN main_categories ON main_categories.id = nurses.category WHERE bids.requirement_id = ? AND bids.status != 2";

        $query = $this->query($sql, [$req_id]);

        $result = $query->getResult();

        

        $data = [];

        foreach($result as $row) {

            $sql = "SELECT requirements.start_date, requirements.end_date, requirements.start_time, requirements.end_time, customers.first_name AS cus_fname, customers.last_name AS cus_lname FROM requirements LEFT JOIN customers ON customers.id = requirements.user_id LEFT JOIN bids ON bids.requirement_id = requirements.id WHERE bids.id = ? AND bids.status !=2";

            $query = $this->db->query($sql, [$row->id]);
            $result1 = $query->getResult();

            $rrr = [];
            foreach($result1 as $row1) {
                $start_date = $row1->start_date . " " . $row1->start_time;
                $end_date = $row1->end_date . " " . $row1->end_time;
                $row->price = (string)getBidPrice2($start_date, $end_date, $row->price);
                
                $rrr[] = $row1;
            }


            $row->other = $rrr;

            $data[] = $row;

        }

        return $data;

    }
     
        
    
    }