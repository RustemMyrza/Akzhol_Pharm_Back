<?php

namespace Database\Seeders;

use App\Models\Agreement;
use App\Services\FileService;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class AgreementSeeder extends Seeder
{
    private TranslateService $translateService;
    private FileService $fileService;

    public function __construct(TranslateService $translateService, FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->translateService = $translateService;
    }

    public function run(): void
    {
        $documentMainPath = public_path('adminlte-assets/dist/documents/');

        $files = [
            [
                'file' => [
                    'ru' => $this->fileService->createUploadedFile($documentMainPath . 'TermsConditionsRu.docx'),
                    'en' => $this->fileService->createUploadedFile($documentMainPath . 'TermsConditionsEn.docx'),
                ],
                'type' => 0,
            ],
            [
                'file' => [
                    'ru' => $this->fileService->createUploadedFile($documentMainPath . 'PrivacyPolicyRu.docx'),
                    'en' => $this->fileService->createUploadedFile($documentMainPath . 'PrivacyPolicyEn.docx'),
                ],
                'type' => 1,
            ],
            [
                'file' => [
                    'ru' => $this->fileService->createUploadedFile($documentMainPath . 'PersonalDataProcessingRu.docx'),
                    'en' => $this->fileService->createUploadedFile($documentMainPath . 'PersonalDataProcessingEn.docx'),
                ],
                'type' => 2,
            ],
        ];

        foreach ($files as $file) {
            Agreement::query()
                ->create([
                    'link' => $this->translateService->createTranslateFile($file['file'], Agreement::FILE_PATH),
                    'type' => $file['type']
                ]);
            unset($file);
        }
    }

}
