<?php
namespace App\Services;

use App\Http\Resources\PersonalRecordResource;
use App\Models\Movement;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Class MovementService
 * 
 * @package App\Services
 */
class MovementService
{
  private $rankingLimit = 20;
  private $useCache = true;
  private $cacheExpirationSeconds = 60;

  /**
   * Get user ranking by movement
   *
   * @param Movement $movement
   * @return JsonResource
   */
  public function getMovementRanking(Movement $movement): JsonResource
  {
    $ranking = $this->useCache
      ? $this->getCachedPersonalRecordByMovement($movement)
      : $this->getPersonalRecordByMovement($movement);
    $ranking = $this->setRankingPosition($ranking);

    return PersonalRecordResource::collection($ranking);
  }

  /**
   * Get movement ranking cache
   *
   * @param Movement $movement
   * @return Collection
   */
  private function getCachedPersonalRecordByMovement(Movement $movement): Collection
  {
    return Cache::remember("movement:{$movement->id}:ranking", $this->cacheExpirationSeconds, function () use ($movement) {
      return $this->getPersonalRecordByMovement($movement);
    });
  }

  /**
   * Get Personal Record By Movement
   *
   * @param Movement $movement
   * @return Collection
   */
  private function getPersonalRecordByMovement(Movement $movement): Collection
  {
    $data = DB::select('
      SELECT user.name, record, date
      FROM personal_record
      INNER JOIN (
        SELECT MAX(pr.value) as record, pr.user_id, pr.movement_id
        FROM personal_record pr
        WHERE pr.movement_id = ?
        GROUP BY pr.user_id
      ) pr2
        ON pr2.record = personal_record.value 
        AND pr2.user_id = personal_record.user_id
        AND pr2.movement_id = personal_record.movement_id
      INNER JOIN user
        ON user.id = personal_record.user_id
      ORDER BY record DESC
      LIMIT ?
    ', [$movement->id, $this->rankingLimit]);

    return Collect($data);
  }

  /**
   * Set user rank position
   *
   * @param Collection $ranking
   * @return Collection
   */
  private function setRankingPosition(Collection $ranking): Collection
  {
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