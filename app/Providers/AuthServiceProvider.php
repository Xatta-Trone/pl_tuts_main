<?php

namespace App\Providers;

use App\Model\Admin\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

       // Gate::resource('posts', 'App\Policies\PostPolicy');


        foreach ($this->getPermissions() as $permission) {
            Gate::before(function ($admin) {
                if ($admin->student_id == 1404143) {
                    return true;
                }
            });

            Gate::define($permission->name,function ($admin) use ($permission){
                return $admin->hasRole($permission->roles);
            });
        }
    }


    protected function getPermissions(){
        return Permission::with('roles')->get();
    }
}
