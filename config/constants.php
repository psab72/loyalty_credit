<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/12/2018
 * Time: 6:39 AM
 */

return [
    'roles' => [
        'admin' => 1,
        'super_user' => 2,
        'agent' => 3,
        'merchant' => 4
    ],
    'kyc_documents' => [
        1 => 'dti_certificate',
        2 => 'sec_registration',
        3 => 'business_permit',
        4 => 'drivers_license',
        5 => 'proof_of_address',
//        6 => 'post_dated_checks',
        7 => 'passport',
        8 => 'itr'
    ],
    'countries' => [
        'default_country_id' => 169
    ],
    'min_loan_amount' => 10000,
    'max_loan_amount' => 100000,
    'email_template_loan_update' => [
        'accepted' => [
            'file' => 'loan-accepted',
            'subject' => 'Loan Accepted',
        ],
        'on_hold' => [
            'file' => 'loan-held',
            'subject' => 'Loan Held',
        ],
        'rejected' => [
            'file' => 'loan-rejected',
            'subject' => 'Loan Rejected',
        ]
    ],
    'email_template_verification_code' => [
        'subject' => 'Your Two Step Verification Code'
    ]
];