<?php

namespace App\Services\Admin;

use App\Services\FileService;
use App\Services\MediaTranslateService;
use App\Services\TranslateService;

class Service
{
    protected TranslateService $translateService;
    protected FileService $fileService;
    protected MediaTranslateService $mediaTranslateService;

    public function __construct(TranslateService $translateService, MediaTranslateService $mediaTranslateService, FileService $fileService)
    {
        $this->translateService = $translateService;
        $this->mediaTranslateService = $mediaTranslateService;
        $this->fileService = $fileService;
    }
}
