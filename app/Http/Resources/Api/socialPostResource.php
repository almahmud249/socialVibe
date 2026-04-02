<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class socialPostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => (int) $this->id,
            'content'    => $this->user->name                                             ?? '',
            'link'       => $this->user->email                                            ?? '',
            'status'     => countryCode($this->user->phone_country_id).$this->user->phone ?? '',
            'images'     => $this->user->lastActivity ? $this->user->lastActivity->created_at->diffForHumans() : '',
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
