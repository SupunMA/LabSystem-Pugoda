<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Auth\SessionGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Set a custom remember me duration (30 days)
        $this->setRememberMeDuration(config('session.remember_lifetime', 43200));
    }

    /**
     * Set a custom duration for the "remember me" cookie.
     *
     * @param int $minutes
     * @return void
     */
    protected function setRememberMeDuration($minutes)
    {
        // Extend the SessionGuard to override the cookie duration
        Auth::extend('session', function ($app, $name, array $config) use ($minutes) {
            $provider = Auth::createUserProvider($config['provider'] ?? null);

            $guard = new SessionGuard($name, $provider, $app['session.store']);

            // Set the remember duration
            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($app['cookie']);
            }

            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($app['events']);
            }

            // Set the custom remember duration
            if (method_exists($guard, 'setRememberDuration')) {
                $guard->setRememberDuration($minutes);
            }

            return $guard;
        });

        // Register a listener to modify the cookie when it's created
        $this->app['events']->listen('auth.login', function ($user, $remember) use ($minutes) {
            if ($remember) {
                $recaller = Cookie::get(Auth::guard()->getRecallerName());
                if ($recaller) {
                    Cookie::queue(
                        Auth::guard()->getRecallerName(),
                        $recaller,
                        $minutes
                    );
                }
            }
        });
    }
}
