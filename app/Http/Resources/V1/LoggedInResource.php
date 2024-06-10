<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\User\UserMeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoggedInResource extends JsonResource
{
    public static $wrap = [];

    public function toArray($request): array
    {
        return [
            'token_type' => "Bearer",
            'token' => $this->resource['token']['plainTextToken'],
            'expires_in' => $this->resource['token']['accessToken']['expires_at'],
            'user' => new UserMeResource($this->resource['user']),
        ];
    }
}
