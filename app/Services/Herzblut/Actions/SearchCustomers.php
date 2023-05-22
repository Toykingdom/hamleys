<?php

namespace App\Services\Herzblut\Actions;

use App\Services\Herzblut\TraderClient;
use App\Services\Herzblut\Contracts\SearchesCustomers;
use Illuminate\Support\Facades\Validator;

class SearchCustomers implements SearchesCustomers {

    /**
     * Validate and create a newly registered customer with the Trader SOAP service.
     *
     * @param  string  $input
     * @return mixed
     */
    public static function search(string $input)
    {
        Validator::make(['search_string' => $input], [
            'search_string' => ['required', 'string', 'max:255']
        ])->validate();

        // @TODO parse $response for success or error
        $response = TraderClient::searchCustomers($input);

        return TraderClient::normalizeArray($response, 'TraderCustomer');
    }
}
