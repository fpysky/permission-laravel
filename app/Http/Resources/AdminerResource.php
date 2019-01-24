<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account' => $this->account,
            'nick_name' => $this->nick_name,
            'avatar' => $this->avatar,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i')
        ];
    }
}
