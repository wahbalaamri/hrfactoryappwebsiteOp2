<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Plans;
use App\Models\ServiceApproaches;
use App\Models\ServiceFeatures;
use App\Models\Services;
use App\Policies\PlansPolicy;
use App\Policies\ServiceApproachesPolicy;
use App\Policies\ServiceFeaturesPolicy;
use App\Policies\ServicesPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Services::class=>ServicesPolicy::class,
        ServiceFeatures::class=>ServiceFeaturesPolicy::class,
        ServiceApproaches::class=>ServiceApproachesPolicy::class,
        Plans::class=>PlansPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
