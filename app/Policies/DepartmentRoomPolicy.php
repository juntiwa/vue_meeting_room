<?php

namespace App\Policies;

use App\Models\DepartmentBookRoom;
use App\Models\DepartmentRoom;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentRoomPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewListBookedRoom(User $user, DepartmentRoom $room)
    {
        return $room->medicineroom->requester_id === $user->id
            || $user->role_id->contains(1);
    }
}
