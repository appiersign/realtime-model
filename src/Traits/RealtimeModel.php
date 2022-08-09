<?php

namespace AppierSign\RealtimeModel\Traits;

use AppierSign\RealtimeModel\Jobs\FirestoreJob;
use AppierSign\RealtimeModel\Observers\RealtimeModelObserver;
use Illuminate\Support\Str;

trait RealtimeModel
{
    public static function bootRealtimeModel(): void
    {
        static::observe(new RealtimeModelObserver);
    }

    public function toRealtimeData(): array
    {
        return $this->toArray();
    }

    protected function collection(): string
    {
        return Str::plural(explode('\\', get_class(new static))[2]);
    }

    public function syncData(string $key): void
    {
        FirestoreJob::dispatch($this->collection(), $key, $this)->afterResponse();
    }

    public function getSyncKey(): string
    {
        return 'external_id';
    }

    public function parents(): array
    {
        return ['user'];
    }

    public function touchesParent(): bool
    {
        return false;
    }
}
