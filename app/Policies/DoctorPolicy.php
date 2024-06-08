<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, Doctor $doctor)
    {
        return $user->isAdmin() || $user->id === $doctor->user_id;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Doctor $doctor)
    {
        return $user->isAdmin() || $user->id === $doctor->user_id;
    }

    public function delete(User $user, Doctor $doctor)
    {
        return $user->isAdmin();
    }
}
