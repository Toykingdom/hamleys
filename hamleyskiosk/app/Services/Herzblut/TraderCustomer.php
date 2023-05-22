<?php

namespace App\Services\Herzblut;

use App\Services\Herzblut\Contracts\TraderMapper;

class TraderCustomer implements TraderMapper
{
    public $account_number;
    public $first_name;
    public $last_name;
    public $mobile_number;
    public $email;
    public $store_name;
    public $customer_type_id;

    public function __construct($input, $inputType='input') {
        switch ($inputType) {
            case 'trader':
                $this->mapTraderToClass($input);
                break;
            default:
                $this->mapInputToClass($input);
                break;
        }
    }

    public function flatten()
    {
        return [
            'account_number' => $this->account_number,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'store_name' => $this->store_name,
            'customer_type_id' => $this->customer_type_id,
        ];
    }

    public function mapInputToClass($input)
    {
        $this->account_number = $input['account_number'];
        $this->first_name = $input['first_name'];
        $this->last_name = $input['last_name'];
        $this->mobile_number = $input['mobile_number'];
        $this->email = $input['email'];
        $this->store_name = $input['store_name'];
        $this->customer_type_id = $input['customer_type_id'];
    }

    public function mapTraderToClass($input) {
        $this->account_number = $input['db_accountcode'];
        $this->first_name = $input['contactname'];
        $this->last_name = $input['surname'];
        $this->mobile_number = $input['db_mobile'];
        $this->email = $input['db_emailaddress'];
        $this->store_name = $input['db_userfield1'];
        $this->customer_type_id = $input['db_customertype_id'];
    }

    public function mapClassToTrader()
    {
        return [
            "Accountcode" => $this->account_number,
            "Title" => '',
            "Initials" => '',
            "Surname" => $this->last_name,
            "ContactName" => $this->first_name,
            "IDNumber" => "",
            "DateOfBirth" => "",
            "ResidentialAddressLine1" => "",
            "ResidentialAddressLine2" => "",
            "ResidentialSuburb" => "",
            "ResidentialTown" => "",
            "ResidentialPostalCode" => "",
            "PostalAddressLine1" => "",
            "PostalAddressLine2" => "",
            "PostalSuburb" => "",
            "PostalTown" => "",
            "PostalCode" => "",
            "MobileNo" => $this->mobile_number,
            "EmailAddress" => $this->email,
            "UserField1" => $this->store_name, // referrer
            "UserField2" => "",
            "CustomerType" => $this->customer_type_id, // customer type ID (28 for Hamleys)
            "LoyaltyPoints" => "",
            "LoyaltyPointsValue" => "",
            "LoyaltyDiscount" => "",
            "LoyaltyID" => "",
        ];
    }
}
