<?php

namespace App\Observers;

use App\Models\PersonalRecord;
use Illuminate\Support\Facades\Cache;

/**
 * Class PersonalRecordObserver
 * 
 * @package App\Observers
 */
class PersonalRecordObserver
{
    /**
     * @param PersonalRecord $personalRecord
     * @return void
     */
    public function created(PersonalRecord $personalRecord)
    {
        $this->deleteRankingCache($personalRecord->movement_id);
    }

    /**
     * @param PersonalRecord $personalRecord
     * @return void
     */
    public function updated(PersonalRecord $personalRecord)
    {
        $this->deleteRankingCache($personalRecord->movement_id);
    }

    /**
     * @param PersonalRecord $personalRecord
     * @return void
     */
    public function deleted(PersonalRecord $personalRecord)
    {
        $this->deleteRankingCache($personalRecord->movement_id);
    }

    /**
     * @param integer $movementId
     * @return void
     */
    private function deleteRankingCache(int $movementId): void
    {
        Cache::delete("movement:{$movementId}:ranking");
    }
}
