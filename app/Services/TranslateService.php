<?php

namespace App\Services;

use App\Models\Translate;

class TranslateService
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function createTranslateFile(array $file, string $path): int
    {
        $translate = new Translate();

        foreach (Translate::LANGUAGES as $language) {
            if (isset($file[$language]) && $file[$language] !== '') {
                $translate->{$language} = $this->fileService->saveFile($file[$language], $path);
            } else {
                $translate->{$language} = null;
            }
        }

        $translate->save();
        return $translate->id;
    }

    public function updateTranslateFile(array $data, string $path, $id): int
    {
        $translate = Translate::query()->find($id);
        if ($translate) {
            foreach (Translate::LANGUAGES as $language) {
                if (isset($data[$language])) {
                    $file = $this->fileService->saveFile($data[$language], $path, $translate->{$language});
                    $translate->{$language} = $file;
                }
            }
            $translate->save();
        }
        return $translate->id;
    }

    public function deleteTranslateFile(int $id, string $path)
    {
        $translate = Translate::query()->find($id);

        foreach (Translate::LANGUAGES as $language) {
            $this->fileService->deleteFile($translate->{$language}, $path);
        }

        return $translate->delete();
    }

    public function createTranslate(array $text): int
    {
        $translate = new Translate();
        foreach (Translate::LANGUAGES as $language) {
            $translate->{$language} = $this->removeSummernoteTags($text[$language]);
        }
        $translate->save();
        return $translate->id;
    }

    public function sortedTranslate(string $text): int
    {
        $translate = new Translate();
        foreach (Translate::LANGUAGES as $language) {
            $translate->{$language} = $text;
        }
        $translate->save();
        return $translate->id;
    }

    public function clearedText(array $text): array
    {
        $translatedText = [];
        foreach (Translate::LANGUAGES as $language) {
            if ($this->removeSummernoteTags($text[$language]) != '') {
                $translatedText[$language] = $this->removeSummernoteTags($text[$language]);
            } else {
                $translatedText[$language] = null;
            }
        }
        return $translatedText;
    }

    public function updateTranslate($id, array $text)
    {
        $translate = Translate::query()->find($id);

        if ($translate) {
            foreach (Translate::LANGUAGES as $language) {
                if ($this->removeSummernoteTags($text[$language]) != '') {
                    $translate->{$language} = $this->removeSummernoteTags($text[$language]);
                } else {
                    $translate->{$language} = null;
                }
            }
            $translate->save();
        } else {
            $translate = $this->createTranslate($text);
        }

        return $translate->id;
    }

    public function removeSummernoteTags($text): string
    {
        $pattern = "/<script.*?<\/script>/si";
        $text = preg_replace($pattern, '', $text);

        return trim(str_replace('<p><br></p>', '', $text));
    }
}
