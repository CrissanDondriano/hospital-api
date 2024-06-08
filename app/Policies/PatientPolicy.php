<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, Patient $patient)
    {
        return $user->isAdmin() || $user->isDoctor() || $user->id === $patient->user_id;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Patient $patient)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Patient $patient)
    {
        return $user->isAdmin();
    }
}
