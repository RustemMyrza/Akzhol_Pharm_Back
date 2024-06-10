<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Services\FileService;
use App\Services\TranslateService;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    protected FileService $fileService;
    private TranslateService $translateService;

    public function __construct(FileService $fileService, TranslateService $translateService)
    {
        $this->translateService = $translateService;
        $this->fileService = $fileService;
    }

    public function run(): void
    {
        $imageMainPath = public_path('adminlte-assets/dist/img/sliders/');
        $sliders = [
            [
                'title' => [
                    'ru' => 'Как работает ручной пылесос?',
                    'en' => 'Как работает ручной пылесос?',
                ],
                'description' => [
                    'ru' => 'С помощью центробежной силы пыль и мелкий мусор вместе с воздушными массами попадают в пылесос. Частицы грязи направляются в контейнер и оседают на его стенках. Воздух проходит несколько ступеней очистки и возвращается в помещение.',
                    'en' => 'С помощью центробежной силы пыль и мелкий мусор вместе с воздушными массами попадают в пылесос. Частицы грязи направляются в контейнер и оседают на его стенках. Воздух проходит несколько ступеней очистки и возвращается в помещение.',
                ],
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'slider-default-image.png'),
                'position' => 1
            ],
            [
                'title' => [
                    'ru' => 'Как работает ручной пылесос?',
                    'en' => 'Как работает ручной пылесос?',
                ],
                'description' => [
                    'ru' => 'С помощью центробежной силы пыль и мелкий мусор вместе с воздушными массами попадают в пылесос. Частицы грязи направляются в контейнер и оседают на его стенках. Воздух проходит несколько ступеней очистки и возвращается в помещение.',
                    'en' => 'С помощью центробежной силы пыль и мелкий мусор вместе с воздушными массами попадают в пылесос. Частицы грязи направляются в контейнер и оседают на его стенках. Воздух проходит несколько ступеней очистки и возвращается в помещение.',
                ],
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'slider-default-image.png'),
                'position' => 2
            ],
            [
                'title' => [
                    'ru' => 'Как работает ручной пылесос?',
                    'en' => 'Как работает ручной пылесос?',
                ],
                'description' => [
                    'ru' => 'С помощью центробежной силы пыль и мелкий мусор вместе с воздушными массами попадают в пылесос. Частицы грязи направляются в контейнер и оседают на его стенках. Воздух проходит несколько ступеней очистки и возвращается в помещение.',
                    'en' => 'С помощью центробежной силы пыль и мелкий мусор вместе с воздушными массами попадают в пылесос. Частицы грязи направляются в контейнер и оседают на его стенках. Воздух проходит несколько ступеней очистки и возвращается в помещение.',
                ],
                'image' => $this->fileService->createUploadedFile($imageMainPath . 'slider-default-image.png'),
                'position' => 3
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::query()
                ->create([
                    'title' => $this->translateService->createTranslate($slider['title']),
                    'description' => $this->translateService->createTranslate($slider['description']),
                    'image' => $this->fileService->saveFile($slider['image'], Slider::IMAGE_PATH),
                    'position' => $slider['position']
                ]);
            unset($slider);
        }
    }
}
