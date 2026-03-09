<?php

namespace App\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            'user' => new UserResource($this->resource['user']),
            'token' => $this->resource['token'] ?? null,
        ];
    }
}
