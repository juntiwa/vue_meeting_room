<?php

namespace App\Policies;

use App\Models\DepartmentBookRoom;
use App\Models\DepartmentRoom;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentBookRoomPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public  function edit(User $user, DepartmentBookRoom $booking)
    {
        return  $booking->requester_id === $user->id
            || $user->role_id->contains(1);
    }

    public function cancel(User $user, DepartmentBookRoom $booking)
    {
        return $booking->requester_id === $user->id;
    }

    public function  appropved(User $user, DepartmentBookRoom $booking)
    {
        return $booking->occupied_raw_statuses->contains($booking->status);
    }
}
