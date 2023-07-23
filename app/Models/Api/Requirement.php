<?php

namespace App\Models\Api;

use CodeIgniter\Model;

class Requirement extends Model
{
    protected $table = 'requirements';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'user_id', 'category', 'start_date', 'end_date', 'start_time', 'end_time', 'area', 'details', 'budget', 'status'
    ];
    protected $useTimestamps = true;

    public function getAllReuirements($id = null)
    {
        $sql = "SELECT requirements.*, main_categories.name as cate_name, customers.first_name AS user_name, customers.last_name AS user_lname, customers.email AS user_email, customers.mobile AS user_phone, customers.profile_photo FROM requirements LEFT JOIN main_categories ON requirements.category = main_categories.id LEFT JOIN customers ON customers.id = requirements.user_id where requirements.status != 'completed'";
        if($id) {
            $sql .= " AND requirements.id = " . $id . " ORDER BY requirements.created_at DESC";
            $query = $this->db->query($sql);
            $result = $query->getResult();


            // $sql2 = "SELECT requirement_bookings.*, nurses.first_name AS nurse_fname, nurses.last_name AS nurse_lname, main_categories.name AS cate_name, nurses.working_hours FROM requirement_bookings LEFT JOIN nurses ON nurses.id = requirement_bookings.nurse_id LEFT JOIN main_categories ON main_categories.id = nurses.category WHERE requirement_bookings.requirement_id = ?";
            // $query2 = $this->db->query($sql2, [$id]);
            // $result[0]->selected_nurse = "";
            // $result[0]->selected_nurse = $query2->getRow();

            $rr = [];
            foreach($result as $row) {
                $sql = "SELECT bids.*, 
                nurses.first_name, nurses.last_name, nurses.email, nurses.phone,
                nurses.work_title, nurses.about, nurses.expertise, nurses.category, nurses.working_hours, nurses.date_of_birth, nurses.marital_status, nurses.skills, nurses.visa_type, nurses.photo, nurses.working_type, nurses.nationality, nurses.experience, nurses.city, nurses.address, nurses.EID, nurses.passport_no,nurses. passport, nurses.confirmed, nurses.status, nurses.speaking_languages,
                main_categories.name AS cate_name, nurses.working_hours 
                FROM bids LEFT JOIN nurses ON nurses.id = bids.nurse_id LEFT JOIN main_categories ON main_categories.id = nurses.category WHERE bids.requirement_id = ? AND bids.status != 2 ORDER BY bids.created_at DESC";
                $query = $this->db->query($sql, [$row->id]);
                $result1 = $query->getResult();

                $ba = [];
                foreach($result1 as $row1) {
                    //var_dump($row->end_time); die();
                    $start_date = $row->start_date . " " . $row->start_time;
                    $end_date = $row->end_date . " " . $row->end_time;
                    $row1->price = getBidPrice2($start_date, $end_date, $row1->price);
                    //$row1->price = getBidPrice($row->start_date, $row->end_date, $row->start_time, $row->end_time, $row1->price);
                    $ba[] = $row1;
                }
                $row->bids = $ba;
                //$row->bids = $result1;

                $rr[] = $row;
            }
            return $rr;
        }
        $sql .= " ORDER BY requirements.created_at DESC";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    public function getCustomerRequirements($cid)
    {
        $sql = "SELECT requirements.*, main_categories.name as cate_name, customers.first_name AS user_name, customers.last_name AS user_lname, customers.email AS user_email, customers.mobile AS user_phone, customers.profile_photo FROM requirements LEFT JOIN main_categories ON requirements.category = main_categories.id LEFT JOIN customers ON customers.id = requirements.user_id WHERE customers.id = ? ORDER BY requirements.created_at DESC";
        $query = $this->db->query($sql, [$cid]);
        $result = $query->getResult();

        $rr = [];
        foreach($result as $row) {
            $row->price = '';
            $sql2 = "SELECT requirement_bookings.*, 
            nurses.first_name AS nurse_fname, nurses.last_name AS nurse_lname, nurses.email, nurses.phone, nurses.work_title, nurses.about, nurses.expertise, nurses.category, nurses.working_hours, nurses.date_of_birth, nurses.marital_status, nurses.skills, nurses.visa_type, nurses.photo, nurses.working_type, nurses.nationality, nurses.experience, nurses.city, nurses.address, nurses.EID, nurses.passport_no,nurses. passport, nurses.confirmed, nurses.status, nurses.speaking_languages, main_categories.name AS cate_name, nurses.working_hours FROM requirement_bookings LEFT JOIN nurses ON nurses.id = requirement_bookings.nurse_id LEFT JOIN main_categories ON main_categories.id = nurses.category WHERE requirement_bookings.requirement_id = ? ORDER BY requirement_bookings.booking_date_time DESC";
            $query2 = $this->db->query($sql2, [$row->id]);
            $r = $query2->getRow();
            if($r) {
                $row->price = $r->amount;
                $row->selected_nurse = $r;
            }
            else {
                $row->selected_nurse = "";
            }
            $rr[] = $row;
        }
        return $rr;
    }

    public function AdminCustomerRequirements($cust) {
        $sql = "SELECT requirements.*, main_categories.name AS cate_name FROM requirements LEFT JOIN main_categories ON main_categories.id = requirements.category WHERE requirements.user_id = ? ORDER BY requirements.created_at DESC";
        $query = $this->db->query($sql, [$cust]);
        return $query->getResult();
    }
}