<?php

namespace App\Providers;

use App\Extensions\HybridUserProvider;
use App\Extensions\PincodeUserProvider;
use App\Policies\ProductPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

use App\Models\Product;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Product::class => ProductPolicy::class,

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

        Passport::tokensExpireIn(Carbon::now()->addHours(1));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }
}
