<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AgreementResource extends JsonResource
{
    public function toArray($request): array
    {
        $title = match ($this->type) {
            0 => trans('messages.type_0'),
            1 => trans('messages.type_1'),
            2 => trans('messages.type_2'),
        };

        return [
            'title' => $title,
            'link'  => $this->fileTranslate ? $this->fileUrl($this->fileTranslate, $request->language) : null,
            'type'  => $this->type,
        ];
    }
}
