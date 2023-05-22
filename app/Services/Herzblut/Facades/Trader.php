<?php
namespace App\Services\Herzblut\Facades;

use Illuminate\Support\Facades\Facade;

class Trader extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'trader';
    }
}
