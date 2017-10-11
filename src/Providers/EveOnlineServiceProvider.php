<?php

namespace matthewpennell\Socialite\EveOnline\Providers;

use Illuminate\Support\ServiceProvider;

class EveOnlineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'eveonline-sisi',
            function ($app) use ($socialite) {
                $config = $app['config']['services.eveonline-sisi'];
                return $socialite->buildProvider(EveOnlineSocialiteProvider::class, $config);
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/services.php', 'services'
        );
    }
}