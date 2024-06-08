<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isDoctor();
    }

    public function view(User $user, Appointment $appointment)
    {
        return $user->isAdmin() || $user->isDoctor() || $user->id === $appointment->patient_id;
    }

    public function create(User $user)
    {
        return $user->isAdmin() || $user->isPatient();
    }

    public function update(User $user, Appointment $appointment)
    {
        return $user->isAdmin() || $user->id === $appointment->doctor_id;
    }

    public function delete(User $user, Appointment $appointment)
    {
        return $user->isAdmin() || $user->id === $appointment->patient_id;
    }
}
