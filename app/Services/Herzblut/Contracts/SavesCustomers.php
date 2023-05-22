<?php

namespace App\Services\Herzblut\Contracts;

use App\Services\Herzblut\TraderCustomer;

interface SavesCustomers
{
    /**
     * Create the given customer.
     *
     * @param  TraderCustomer  $model
     * @return bool
     */
    public static function save(TraderCustomer $model): bool;
}
