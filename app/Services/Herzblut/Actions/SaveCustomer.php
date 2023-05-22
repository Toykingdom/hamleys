<?php

namespace App\Services\Herzblut\Actions;

use App\Services\Herzblut\TraderClient;
use App\Services\Herzblut\TraderCustomer;
use App\Services\Herzblut\Contracts\SavesCustomers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class SaveCustomer implements SavesCustomers {

    /**
     * Validate and create a newly registered customer with the Trader SOAP service.
     *
     * @param TraderCustomer $model
     * @return bool
     * @throws ValidationException
     */
    public static function save(TraderCustomer $model): bool
    {
        Validator::make($model->flatten(), [
            'account_number' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_number' => ['required', 'string', 'max:10'],
            'store_name' => ['required', 'string', 'max:255'],
            'customer_type_id' => ['required', 'integer']
        ])->validate();

        return TraderClient::sendCustomer($model);

    }
}
