<?php

namespace App\Services\Herzblut\Actions;

use App\Services\Herzblut\TraderClient;
use App\Services\Herzblut\Contracts\FetchesCustomers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FetchCustomer implements FetchesCustomers {

    /**
     * Validate and create a newly registered customer with the Trader SOAP service.
     *
     * @param string $input
     * @return mixed
     * @throws ValidationException
     */
    public static function fetch(string $input)
    {
        Validator::make(['account_code' => $input], [
            'account_code' => ['required', 'string', 'max:255']
        ])->validate();

        // @TODO parse $response for success or error
        $response = TraderClient::fetchCustomer($input);

        return (is_array($response)) ? TraderClient::normalizeSingle($response, 'TraderCustomer') : null;
    }
}
