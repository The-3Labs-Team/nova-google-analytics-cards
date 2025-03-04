<?php

namespace The3LabsTeam\NovaGoogleAnalyticsCards;

use Illuminate\Support\ServiceProvider;

// use Outl1ne\NovaTranslationsLoader\LoadsNovaTranslations;

class NovaGoogleAnalyticsCardsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    //    use LoadsNovaTranslations;

    public function boot()
    {

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'nova-google-analytics-cards');

        $this->publishes([
            __DIR__.'/../config/nova-google-analytics-cards.php' => config_path('nova-google-analytics-cards.php'),
        ], 'config');

        //        $this->loadTranslations(__DIR__.'/../lang', 'nova-google-analytics-cards', true);
    }

    /**
     * Register the application services.
     */
    public function register() {}
}
