<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MedicalRecordPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isDoctor();
    }

    public function view(User $user, MedicalRecord $record)
    {
        return $user->isAdmin() || $user->isDoctor() || $user->id === $record->patient->user_id;
    }

    public function create(User $user)
    {
        return $user->isAdmin() || $user->isDoctor();
    }

    public function update(User $user, MedicalRecord $record)
    {
        return $user->isAdmin() || $user->id === $record->doctor_id;
    }

    public function delete(User $user, MedicalRecord $record)
    {
        return $user->isAdmin();
    }
}
