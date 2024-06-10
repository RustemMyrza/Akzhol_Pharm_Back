<?php

namespace App\Services\Api\V1;

use App\Models\Application;

class ApplicationService
{
    public function create(array $data)
    {
        return Application::query()->create($data);
    }
}
