<?php

namespace AppierSign\RealtimeModel\Observers;

class RealtimeModelObserver
{
    public function created($model): void
    {
        logger()->info("### Sync Created Data ###");
        $model->syncData($model->{$model->getSyncKey()});
        $this->touchParents($model);
    }

    public function updated($model): void
    {
        logger()->info("### Sync Updated Data ###");
        $model->syncData($model->{$model->getSyncKey()});
        $this->touchParents($model);
    }

    private function touchParents($model): void
    {
        if ($model->touchesParent()) {
            foreach ($model->parents() as $parent) {
                $model->{$parent}->syncData($model->{$parent}->{$parent->getSyncKey()});
            }
        }
    }
}
