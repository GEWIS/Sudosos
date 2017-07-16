<?php

namespace App\Providers;

use App\Extensions\HybridUserProvider;
use App\Extensions\PincodeUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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

        Auth::provider('hybrid', function ($app, array $config) {
            return new HybridUserProvider($config['jwt_secret']);
        });

        Auth::provider('pin', function ($app, array $config) {
            return new PincodeUserProvider();
        });


        Passport::routes();
    }
}
