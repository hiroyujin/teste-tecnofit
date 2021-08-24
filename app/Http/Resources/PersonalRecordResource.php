<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PersonalRecordResource
 * 
 * @package App\Http\Resources
 */
class PersonalRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'position' => $this->position,
            'name' => $this->name,
            'record' => $this->record,
            'date' => $this->date
        ];
    }
}
