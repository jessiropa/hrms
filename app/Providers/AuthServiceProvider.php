<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        

        Gate::define('manage-users', function($user){
            return $user->role === 'admin';
        });
        Gate::define('manage-departments', function($user){
            return $user->role === 'admin' || $user->role === 'hr';
        });
        Gate::define('manage-employees', function($user){
            return $user->role === 'admin' || $user->role === 'hr';
        });
        Gate::define('view-dashboard', function($user){
            // dd($user->role);
            // dd(Auth::user()->id, Auth::user()->email, Auth::user()->employee);
            return $user->role === 'admin' || $user->role === 'hr'|| $user->role === 'employee';
        });

        Gate::define('submit-leave-request', function ($user) {
            return $user->role === 'employee' || $user->role === 'admin'; // Admin juga bisa mengajukan cuti
        });

        Gate::define('manage-leave-requests', function ($user) {
            return $user->role === 'admin' || $user->role === 'hr'; // Hanya admin dan HR yang bisa mengelola
        });
    }
}