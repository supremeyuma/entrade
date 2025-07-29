<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Trade;
use App\Observers\TradeObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('blade.compiler', function () {
            return new \Illuminate\View\Compilers\BladeCompiler(
                $this->app['files'],
                $this->app['config']['view.compiled']
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Trade::observe(TradeObserver::class);
    }
}
