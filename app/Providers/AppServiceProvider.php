<?php

namespace App\Providers;

use App\Models\Article;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Observers\ArticleObserver;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Article::observe(ArticleObserver::class);

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        $settings = Setting::all();

        $settingsArray = $settings->mapWithKeys(function ($setting) {

            return [
                $setting->key => [
                    'value'     => $setting->value,
                ]
            ];
        })->toArray();

        view()->share('settingsArray', $settingsArray);
    }
}
