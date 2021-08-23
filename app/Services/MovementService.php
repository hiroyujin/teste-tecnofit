<?php
namespace App\Services;

use App\Models\Movement;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Cache;

/**
 * Class MovementService
 * 
 * @package App\Services
 */
class MovementService
{
  /**
   * Get user ranking by movement
   *
   * @param Movement $movement
   * @return array
   */
  public function getMovementRanking(Movement $movement): Collection
  {
    $ranking = Cache::rememberForever("movement:ranking:{$movement->id}", function () use ($movement) {
        return $this->getPersonalRecordByMovement($movement);
    });

    return $this->setRankingPosition($ranking);
  }

  /**
   * Get Personal Record By Movement
   *
   * @param Movement $movement
   * @return EloquentCollection
   */
  private function getPersonalRecordByMovement(Movement $movement): EloquentCollection
  {
    return $movement
      ->personalRecords()
      ->selectRaw('user.name, MAX(personal_record.value) as record, personal_record.date')
      ->join('user', 'personal_record.user_id', '=', 'user.id')
      ->groupBy('user_id')
      ->orderBy('record', 'DESC')
      ->get();
  }

  private function setRankingPosition($ranking) {
    $position = 1;
    return $ranking->map(function ($row, $index) use($position, $ranking) {
      if (isset($ranking[$index - 1]) && $ranking[$index - 1]->record !== $row->record) {
        $position = $index + 1;
      }
      $row->position = $position;
      return $row;
    });
  }
}