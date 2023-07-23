<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use App\Validations\BookingValidations;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        BookingValidations::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $nurse_update = [
        'first_name' => [
            'label' => 'First Name',
            'rules' => 'trim|required',
        ],
        'middle_name' => [
            'label' => 'Middle Name',
            'rules' => 'trim',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'rules' => 'trim',
        ],
        'email' => [
            'label' => 'Email Address',
            'rules' => 'trim|required',
        ],
        'mobile' => [
            'label' => 'Mobile no.',
            'rules' => 'trim|required',
        ],
        'address' => [
            'label' => 'Address',
            'rules' => 'trim|required',
        ],
        'work_title' => [
            'label' => 'Work Title',
            'rules' => 'trim',
        ],
        'about' => [
            'label' => 'About Nurse',
            'rules' => 'trim|required',
        ],
        'expertise' => [
            'label' => 'Expertise',
            'rules' => 'trim|required',
        ],
        'category' => [
            'label' => 'Category',
            'rules' => 'trim|required',
        ],
        'working_hours' => [
            'label' => 'Workinh Hours',
            'rules' => 'trim|required',
        ],
        'date_of_birth' => [
            'label' => 'Date of Birth',
            'rules' => 'trim|required',
        ],
        'marital_status' => [
            'label' => 'Marital Status',
            'rules' => 'trim|required',
        ],
        'skills' => [
            'label' => 'Skills',
            'rules' => 'trim',
        ],
        'visa_type' => [
            'label' => 'Visa Type',
            'rules' => 'trim|required',
        ],
        'working_type' => [
            'label' => 'Work Type',
            'rules' => 'trim|required',
        ],
        'city' => [
            'label' => 'City',
            'rules' => 'trim|required',
        ]
    ];
}
