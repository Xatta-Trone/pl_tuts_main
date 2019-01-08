<?php

namespace App\Providers;
use App\Http\Controllers\User\PagesController;
use App\Model\Admin\Department;
use Illuminate\Support\ServiceProvider;

class NavServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('user.partials.nav',function($view){
             $view->with('data', Department::orderBy('slug','asc')->get());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
