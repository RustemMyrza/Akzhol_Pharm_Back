<?php

namespace App\Services\Admin\Instruction;

use App\Models\Instruction;
use App\Models\Translate;
use App\Services\Admin\Service;

class InstructionService extends Service
{
    public function getInstructions(): array
    {
        return [
            'instructions' => Instruction::query()->withTranslations()->paginate()
        ];
    }

    public function create(array $data)
    {
        return Instruction::query()
            ->create([
                'title' => $this->translateService->createTranslate($data['title']),
                'link' => $this->mediaTranslateService->createTranslateFile($data['file'], Instruction::FILE_PATH),
                'is_active' => $data['is_active'] ?? 0,
                'position' => $data['position'] ?? Instruction::lastPosition(),
                'image' => isset($data['image']) ? $this->fileService->saveFile($data['image'], Instruction::IMAGE_PATH) : null,
            ]);
    }

    public function update(Instruction $instruction, array $data)
    {
        $instruction->title = $this->translateService->updateTranslate($instruction->title, $data['title']);
        if (isset($data['file'])) {
            $this->mediaTranslateService->updateTranslateFile($data['file'], Instruction::FILE_PATH, $instruction->link);
        }
        $instruction->is_active = $data['is_active'] ?? 0;
        $instruction->position = $data['position'] ?? Instruction::lastPosition();
        if (isset($data['image'])) {
            $instruction->image = $this->fileService->saveFile($data['image'], Instruction::IMAGE_PATH, $instruction->image);
        }
        return $instruction->save();
    }

    public function delete(Instruction $instruction)
    {
        if ($instruction->fileTranslate) {
            foreach (Translate::LANGUAGES as $language) {
                $this->fileService->deleteFile($instruction->fileTranslate->{$language}, Instruction::FILE_PATH);
            }
            $instruction->fileTranslate?->delete();
        }
        return $instruction->delete();
    }

    public function deleteFile(Instruction $instruction, string $language)
    {
        $file = $instruction->fileTranslate->{$language};

        $this->fileService->deleteFile($file, Instruction::FILE_PATH);

        $instruction->fileTranslate->{$language} = null;
        $instruction->fileTranslate->{$language . '_size'} = null;
        $instruction->fileTranslate->save();

        if ($instruction->image != null) {
            $this->fileService->deleteFile($instruction->image, Instruction::IMAGE_PATH);
        }

        return true;
    }
}
