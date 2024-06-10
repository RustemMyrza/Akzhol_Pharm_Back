<?php

namespace App\Services;

use App\Models\MediaTranslate;

class MediaTranslateService
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function createTranslateFile(array $file, string $path): int
    {
        $mediaTranslate = new MediaTranslate();

        foreach (MediaTranslate::LANGUAGES as $language) {
            if (isset($file[$language]) && $file[$language] !== '') {
                $resultFile = $this->fileService->saveFile($file[$language], $path, null, true);
                $mediaTranslate->{$language} = $resultFile['name'];
                $mediaTranslate->{$language.'_size'} = $resultFile['size'];
            } else {
                $mediaTranslate->{$language} = null;
                $mediaTranslate->{$language.'_size'} = null;
            }
        }

        $mediaTranslate->save();
        return $mediaTranslate->id;
    }

    public function updateTranslateFile(array $data, string $path, $id): int
    {
        $mediaTranslate = MediaTranslate::query()->find($id);
        if ($mediaTranslate) {
            foreach (MediaTranslate::LANGUAGES as $language) {
                if (isset($data[$language])) {
                    $file = $this->fileService->saveFile($data[$language], $path, $mediaTranslate->{$language}, true);
                    $mediaTranslate->{$language} = $file['name'];
                    $mediaTranslate->{$language.'_size'} = $file['size'];
                }
            }
            $mediaTranslate->save();
        }
        return $mediaTranslate->id;
    }

    public function deleteTranslateFile(int $id, string $path)
    {
        $mediaTranslate = MediaTranslate::query()->find($id);
        foreach (MediaTranslate::LANGUAGES as $language) {
            $this->fileService->deleteFile($mediaTranslate->{$language}, $path);
        }
        return $mediaTranslate->delete();
    }
}
