<?php
namespace App\Resources\Movies;

use Illuminate\Http\Resources\Json\JsonResource;
class StatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}