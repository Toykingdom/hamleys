<?php

namespace App\Services\Herzblut\Contracts;

interface FetchesCustomers
{
    /**
     * Create the given customer.
     *
     * @param  string  $input
     * @return mixed
     */
    public static function fetch(string $input);
}
