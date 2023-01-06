<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'flash' => [
                'sirirajUser' => fn () => $request->session()->get('sirirajUser'),
                'replyCode' => fn () => $request->session()->get('replyCode'),
            ],
            'auth.user' => fn () => $request->user()
                ? $request->user()->only('full_name')
                : null,
            'can' => [
                'booked_room_case' => fn () => $request->user()
                    ? $request->user()->abilities->contains('booked_room_case')
                    : null,
                'edit_booked_room_case' => fn () => $request->user()
                    ? $request->user()->abilities->contains('edit_booked_room_case')
                    : null,
                'cancel_booked_room_case' => fn () => $request->user()
                    ? $request->user()->abilities->contains('cancel_booked_room_case')
                    : null,
                'record_data_booked_room_case' => fn () => $request->user()
                    ? $request->user()->abilities->contains('record_data_booked_room_case')
                    : null,
                'record_data_request_equipment_case' => fn () => $request->user()
                    ? $request->user()->abilities->contains('record_data_request_equipment_case')
                    : null,
                'period_booked_room_case' => fn () => $request->user()
                    ? $request->user()->abilities->contains('period_booked_room_case')
                    : null,
                'view_list_booked_room_case' => fn () => $request->user()
                    ? $request->user()->abilities->contains('view_list_booked_room_case')
                    : null,
                'view_list_request_equipment_case' => fn () => $request->user()
                    ? $request->user()->abilities->contains('view_list_request_equipment_case')
                    : null,
            ]
        ]);
    }
}
