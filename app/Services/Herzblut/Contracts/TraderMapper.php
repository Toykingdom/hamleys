<?php

namespace App\Services\Herzblut\Contracts;

interface TraderMapper
{
    /**
     * Create the given customer.
     * @return void
     */
    public function mapClassToTrader();

    public function mapTraderToClass($input);

    public function mapInputToClass($input);

}
