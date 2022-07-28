<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
        //If you do this, make sure you know exactly what's going into the database and you have it set up correctly:
        Model::unguard();
        //Paginator: if you want to change pagination styles, look up documentation. See vendor folder in views.
    }
}
