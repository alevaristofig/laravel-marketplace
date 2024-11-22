<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        
        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("Markeplace")->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName("Markeplace")->setRelease("1.0.0");                
    }
}
