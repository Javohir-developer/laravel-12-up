<?php
namespace App\Resources\Movies;

use Illuminate\Http\Resources\Json\JsonResource;
class MovieResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->whenLoaded('status', 
                fn() => new StatusResource($this->status)
            ),
            // 'status' => $this->whenLoaded('status', fn() => [
            //     'id'   => $this->status->id,
            //     'name' => $this->status->name,
            // ]),
        ];
    }
}