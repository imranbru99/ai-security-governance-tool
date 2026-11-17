<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\GovernancePolicy;
use App\Models\User;

class GovernancePolicyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->canAccessAdmin();
    }

    public function view(User $user, GovernancePolicy $policy): bool
    {
        return $user->role->canAccessAdmin();
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin, UserRole::Manager, UserRole::Demo], true);
    }

    public function update(User $user, GovernancePolicy $policy): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, GovernancePolicy $policy): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Admin], true);
    }
}
