<?php

namespace Database\Seeders;

use App\Models\Instruction;
use App\Services\FileService;
use App\Services\MediaTranslateService;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructionSeeder extends Seeder
{
    private TranslateService $translateService;
    private MediaTranslateService $mediaTranslateService;
    private FileService $fileService;

    public function __construct(TranslateService $translateService, MediaTranslateService $mediaTranslateService, FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->translateService = $translateService;
        $this->mediaTranslateService = $mediaTranslateService;
    }

    public function run(): void
    {
        $documentMainPath = public_path('adminlte-assets/dist/instructions/');

        $instructions = [
            [
                'title' => [
                    'ru' => 'Booster Pump Owner’s Manual',
                    'en' => 'Booster Pump Owner’s Manual',
                ],
                'file' => [
                    'ru' => $this->fileService->createUploadedFile($documentMainPath . 'instruction-1.pdf'),
                    'en' => $this->fileService->createUploadedFile($documentMainPath . 'instruction-1.pdf'),
                ],
            ],
            [
                'title' => [
                    'ru' => 'Booster Pump Owner’s Manual 2',
                    'en' => 'Booster Pump Owner’s Manual 2',
                ],
                'file' => [
                    'ru' => $this->fileService->createUploadedFile($documentMainPath . 'instruction-1.pdf'),
                    'en' => $this->fileService->createUploadedFile($documentMainPath . 'instruction-1.pdf'),
                ],
            ],
        ];

        DB::beginTransaction();
        $index = 1;
        foreach ($instructions as $instruction) {
            Instruction::query()
                ->create([
                    'title' => $this->translateService->createTranslate($instruction['title']),
                    'link' => $this->mediaTranslateService->createTranslateFile($instruction['file'], Instruction::FILE_PATH),
                    'position' => $index
                ]);
            $index = $index + 1;
            unset($instruction);
        }
        DB::commit();
    }

}
