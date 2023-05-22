<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Herzblut\Trader;

class TraderServiceProvider extends ServiceProvider
{
    public function register()
    {
        //Binding our class to service provider
        $this->app->bind('trader',function(){
            return new Trader();
        });
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
