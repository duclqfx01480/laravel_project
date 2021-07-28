<?php

namespace App\Providers;

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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 89
        // Định nghĩa Gate để cho phép kết nối tag với hobby (attach Ttg và detach tag)
        Gate::define('connect_hobbyTag', function($user, $hobby){
            // user được phép attach/detach tag nếu có user id trùng với user id trên hobby
            // hoặc user là admin
            return $user->id === $hobby->user_id || auth()->user()->role === 'admin';
        });
    }
}
