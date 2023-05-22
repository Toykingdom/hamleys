<?php

namespace App\Services\Herzblut\Contracts;

interface SearchesCustomers
{
    /**
     * Create the given customer.
     *
     * @param  string  $input
     * @return mixed
     */
    public static function search(string $input);
}
