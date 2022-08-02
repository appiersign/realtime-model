<?php

namespace AppierSign\RealtimeModel\Commands;

use Exception;
use Illuminate\Console\Command;

class SyncData extends Command
{
    protected $signature = 'realtime:sync {model}';

    protected $description = 'Sync model data with Google Firestore';
    
    private $model = 'App\\Models\\';

    /**
     * @throws Exception
     */
    public function handle()
    {
        if (env('FIRESTORE_SERVER_URI') === null || !mb_strlen(env('FIRESTORE_SERVER_URI'))) throw new Exception('FIRESTORE_SERVER_URI param not set in .env');
        if (env('APP_ENV') === null || !mb_strlen(env('APP_ENV'))) throw new Exception('APP_ENV param not set in .env');
        if (env('APP_NAME') === null || !mb_strlen(env('APP_NAME'))) throw new Exception('APP_NAME param not set in .env');
        if (env('API_GATEWAY_TOKEN') === null || !mb_strlen(env('API_GATEWAY_TOKEN'))) throw new Exception('API_GATEWAY_TOKEN param not set in .env');

        $this->model = $this->model . $this->argument('model');
        
        if (!class_exists($this->model)) throw new Exception($this->model) . ' does not exist!');

        $this->model::query()->chunk(100, function ($models) {
            foreach ($models as $model) {
                echo "Syncing {$this->model}: {$model->{$model->getSyncKey()}}\n";
                $model->syncData($model->{$model->getSyncKey()});
            };
        });
    }
}
