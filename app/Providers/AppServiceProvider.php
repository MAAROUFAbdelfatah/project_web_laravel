<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;    // Must Must use
use Illuminate\Support\Facades\Blade;
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
        //

        Blade::if('isAdmin', function () {
            return Auth::user()->isAdmin();
          
        });

        Blade::if('isCoencadrant', function () {
            return Auth::user()->isCoEncadrant() || Auth::user()->isEncadrant() || Auth::user()->isAdmin();
          
        });

        Blade::if('isEncadrant', function () {
            return Auth::user()->isEncadrant() || Auth::user()->isAdmin();
          
        });


        Blade::if('isEtudiant', function () {
            return Auth::user()->isEtudiant() || Auth::user()->isCoEncadrant() || Auth::user()->isEncadrant() || Auth::user()->isAdmin();
          
        });
        

    }
}
