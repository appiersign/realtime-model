<?php
namespace AppierSign\RealtimeModel\Providers;

use AppierSign\RealtimeModel\Commands\SyncData;
use Illuminate\Support\ServiceProvider;

class RealtimeModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncData::class
            ]);
        }
    }
}
