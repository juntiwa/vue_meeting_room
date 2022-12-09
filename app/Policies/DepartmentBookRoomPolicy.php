<?php

namespace App\Policies;

use App\Models\DepartmentBookRoom;
use App\Models\User;
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

    public function cancel(User $user, DepartmentBookRoom $booking)
    {
        return $booking->requester_id === $user->id;
    }
}
