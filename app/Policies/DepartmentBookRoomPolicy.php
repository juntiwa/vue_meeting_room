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

    public function edit(User $user, DepartmentBookRoom $booking)
    {
        if ($user->role_id->contains(1)) {
            return $booking->occupied_raw_statuses_edit->contains($booking->status)
                && $user->role_id->contains(1)
                && $booking->start_date > Carbon::now();
        }

        return $booking->occupied_raw_statuses_edit->contains($booking->status)
            && $booking->requester_id === $user->id
            && $booking->start_date > Carbon::now()->addWeekdays(4); //add 4 because not counting today and start_date
    }

    public function approved(User $user, DepartmentBookRoom $booking)
    {
        return $booking->occupied_raw_statuses->contains($booking->status)
            && $booking->start_date > Carbon::now()
            && $booking->approver_id === null
            && $user->role_id->contains(1);
    }

    public function disapproved(User $user, DepartmentBookRoom $booking)
    {
        return $booking->occupied_raw_statuses_cancel->contains($booking->status)
            && $booking->start_date > Carbon::now()
            && $booking->approver_id === null
            && $user->role_id->contains(1);
    }

    public function canceled(User $user, DepartmentBookRoom $booking)
    {
        if ($user->role_id->contains(1)) {
            return $booking->occupied_raw_statuses_cancel->contains($booking->status)
                && $booking->start_date > Carbon::now()
                && $booking->approver_id === null
                && $user->role_id->contains(1);
        }

        return $booking->occupied_raw_statuses_cancel->contains($booking->status)
            && $booking->start_date > Carbon::now()->addWeekdays(4) //add 4 because not counting today and start_date
            && $booking->approver_id === null
            && $booking->requester_id === $user->id;

    }
}
