<?php

namespace App\Controllers\Admin;

use App\Models\Api\Bid;
use App\Models\Api\Customer;
use App\Models\Api\Requirement;
use App\Models\Api\RequirementBook;
use App\Controllers\BaseController;

class RequirementController extends BaseController
{
    public function index()
    {
        
    }

    public function customer($id)
    {
        $bookM = new Requirement();
        $requirements = $bookM->AdminCustomerRequirements(DecryptId($id));

        $cModel = new Customer();
        $customer = $cModel->where(['id' => DecryptId($id)])->first();
        
        return view('requirements/customer', [
            'requirements' => $requirements,
            'customer' => $customer
        ]);
    }

    /**
     * @param string $req_id
     * Fetch Requirement, Requirement Booking and Selected Nurse and Updates Record
    */
    public function update($req_id)
    {

    }

    public function bids($req_id) {
        $bModel = new Bid();
        $bids = $bModel->getRequirementBids(DecryptId($req_id));
        return view('requirements/bids', [
            'bids' => $bids
        ]);
    }

    public function confirmBid($req_id, $bid_id)
    {

    }

    public function cancelBid($bid_id)
    {

    }

    public function deleteRequirement($req_id) 
    {

    }
}
