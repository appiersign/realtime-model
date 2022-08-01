<?php
namespace AppierSign\RealtimeModel\Providers;

use AppierSign\RealtimeModel\Commands\SyncData;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class RealtimeModelServiceProvider extends ServiceProvider
{
    public function register()
    {
        AboutCommand::add('Realtime Model', 'Version', '1.0.0');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncData::class
            ]);
        }
    }
}
