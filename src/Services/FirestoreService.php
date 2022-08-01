<?php

namespace AppierSign\RealtimeModel\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class FirestoreService
{
    public static function syncData(string $collection, string $key, $model): void
    {
        try {
            $_collection = app()->environment('production') ? $collection : env('APP_ENV') . '_' . $collection;
            $uri = env('FIRESTORE_SERVER_URI');
            $requestBody = [
                'product' => mb_strtolower(env('APP_NAME')),
                'externalId' => $key,
                'collection' => mb_strtolower($_collection),
                'data' => $model->toRealtimeData()
            ];

            logger()->info('### Syncing Data with Firestore ###');
            logger()->info("### Request URI: $uri ###");
            logger()->info("### Request Body ###");
            logger()->info(json_encode($requestBody));

            sleep(2);

            $request = Http::withToken(env('API_GATEWAY_TOKEN'))->post($uri, $requestBody);

            logger()->info("### Firestore Response Body: " . json_encode($request->json()) . " ###");

        } catch (Exception $exception) {
            report($exception);
        }
    }
}
