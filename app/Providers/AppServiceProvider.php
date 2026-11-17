<?php

namespace App\Providers;

use App\Models\GovernancePolicy;
use App\Policies\GovernancePolicyPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(GovernancePolicy::class, GovernancePolicyPolicy::class);
    }
}
