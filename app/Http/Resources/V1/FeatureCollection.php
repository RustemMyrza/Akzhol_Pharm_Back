<?php

namespace App\Http\Resources\V1;

use App\Enum\FeatureTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FeatureCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        if (count($this->collection) == 0) {
            return $data;
        }

        foreach ($this->collection as $collectionItem) {
            $row = [
                'id' => $collectionItem->id,
                'title' => $collectionItem->titleTranslate?->{$request->language},
                'type' => $collectionItem->type,
                'type_name' => $collectionItem->type_name,
            ];

            $row['featureItems'] = null;

            if (count($collectionItem->featureItems)) {
                if ($collectionItem->type == FeatureTypeEnum::SELECTABLE) {
                    foreach ($collectionItem->featureItems as $featureItem) {
                        $row['featureItems'][] = [
                            'id' => $featureItem->id,
                            'title' => $featureItem->titleTranslate?->{$request->language},
                        ];
                    }
                } else {
                    $numbers = [];
                    foreach ($collectionItem->featureItems as $featureItem) {
                        $numbers[] = (int)$featureItem->titleTranslate?->{$request->language};
                    }

                    $row['featureItems'] = [
                        'min' => min($numbers),
                        'max' => max($numbers),
                    ];
                }
            }

            $data[] = $row;
        }

        return $data;
    }
}
