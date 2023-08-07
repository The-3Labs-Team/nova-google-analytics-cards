<?php

namespace The3LabsTeam\NovaGoogleAnalyticsCards;

use Illuminate\Support\ServiceProvider;
use Outl1ne\NovaTranslationsLoader\LoadsNovaTranslations;

class NovaGoogleAnalyticsCardsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    use LoadsNovaTranslations;

    public function boot()
    {
        $this->loadTranslations(__DIR__.'/../lang', 'nova-google-analytics-cards', true);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}