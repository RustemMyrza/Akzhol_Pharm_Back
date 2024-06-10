<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function deleteFile($name, $path)
    {
        if ($name && Storage::disk('custom')->exists($path . '/' . $name)) {
            return Storage::disk('custom')->delete($path . '/' . $name);
        }
        return null;
    }

    public function saveFile($file, $path, $oldFileName = null, $isFileSize = false)
    {
        if ($oldFileName) {
            $this->deleteFile($oldFileName, $path);
        }

        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $fileNameReplaced = str_replace(' ', '_', $fileName);

        if (Storage::disk('custom')->exists($path . "/$fileNameReplaced")) {
            $fileNameReplaced = explode('.', $fileNameReplaced);
            $extension = array_pop($fileNameReplaced);
            $fileNameReplaced = join('', $fileNameReplaced) . "_" . rand(1, 99) . ".$extension";
        }

        Storage::disk('custom')->putFileAs($path, $file, $fileNameReplaced);

        if ($isFileSize) {
            return [
                'name' => $fileNameReplaced,
                'size' => $fileSize,
            ];
        }

        return $fileNameReplaced;
    }

    function createUploadedFile($filePath): UploadedFile
    {
        $fileInfo = pathinfo($filePath);
        return new UploadedFile($filePath, $fileInfo['basename'], mime_content_type($filePath), null, true);
    }
}
