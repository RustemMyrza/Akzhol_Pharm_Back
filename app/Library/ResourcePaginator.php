<?php
namespace App\Library;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use JsonSerializable;

class ResourcePaginator implements JsonSerializable
{
    private ResourceCollection $collection;
    private LengthAwarePaginator $paginator;

    private const EXCLUDED_KEYS = [
        'links',
        'first_page_url',
        'last_page_url',
        'next_page_url',
        'prev_page_url',
        'path',
    ];

    public function __construct(ResourceCollection $collection)
    {
        $this->collection = $collection;
        $this->paginator = $this->collection->resource;
    }

    public function jsonSerialize(): array
    {
        return Arr::except($this->paginator->toArray(), self::EXCLUDED_KEYS);
    }
}
