<?php

namespace App\Services\Admin\Ckeditor;

use App\Services\Admin\Service;

class CkeditorService extends Service
{
    const PATH = 'ckeditor';

    public function create(object $file): ?string
    {
        $fileName = $this->fileService->saveFile($file, self::PATH);

        return config('app.env' === 'production')
            ? url("uploads/ckeditor/$fileName", [], true)
            : url("uploads/ckeditor/$fileName");
    }

//    public function delete(string $src = null)
//    {
//        $baseUrl = config('app.env') == 'production'
//            ? str_replace('http', 'https', config('app.url')) . '/uploads/ckeditor/'
//            : config('app.url') . '/uploads/ckeditor/';
//
//        $fileName = str_replace($baseUrl, '', $src);
//
//        $this->fileService->deleteFile($fileName, self::PATH);
//    }
}
