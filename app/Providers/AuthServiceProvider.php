<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
//use App\Models\DepartmentBookRoom;
use App\Models\User;
//use App\Policies\DepartmentBookRoomPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
//        DepartmentBookRoom::class => DepartmentBookRoomPolicy::class
        'App\Models\DepartmentBookRoom' => 'App\Policies\DepartmentBookRoomPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->abilities->contains($ability)) {
                return true;
            }
        });

        Gate::define('view_any_cases',function(User $user){
            return $user->role == 'admin';
        });
    }
}
