<?php

namespace AppierSign\RealtimeModel\Commands;

use Exception;
use Illuminate\Console\Command;

class SyncData extends Command
{
    protected $signature = 'realtime:sync {model}';

    protected $description = 'Sync model data with Google Firestore';

    /**
     * @throws Exception
     */
    public function handle()
    {
        if (env('FIRESTORE_SERVER_URI') === null || !mb_strlen(env('FIRESTORE_SERVER_URI'))) throw new Exception('FIRESTORE_SERVER_URI param not set in .env');
        if (env('APP_ENV') === null || !mb_strlen(env('APP_ENV'))) throw new Exception('APP_ENV param not set in .env');
        if (env('APP_NAME') === null || !mb_strlen(env('APP_NAME'))) throw new Exception('APP_NAME param not set in .env');
        if (env('API_GATEWAY_TOKEN') === null || !mb_strlen(env('API_GATEWAY_TOKEN'))) throw new Exception('API_GATEWAY_TOKEN param not set in .env');

        if (!class_exists($this->argument('model'))) throw new Exception($this->argument('model') . ' does not exist!');

        $class = $this->argument('model');

        $this->argument('model')::query()->chunk(100, function ($models) use ($class) {
            foreach ($models as $model) {
                echo "Syncing {$class}: {$class}\n";
                $model->syncData($model->getSyncKey());
            };
        });
    }
}
