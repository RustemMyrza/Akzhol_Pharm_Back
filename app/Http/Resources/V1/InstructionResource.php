<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class InstructionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image_url,
            'title' => $this->titleTranslate->{$request->language},
            'file' => $this->fileTranslate ? $this->fileUrl($this->fileTranslate, $request->language) : null,
            'file_size' => $this->fileTranslate ? fileSizeFormat($this->fileTranslate->{$request->language . '_size'}) : null,
        ];
    }
}
