<?php

namespace App\Exports\Sheets;

use App\Models\Feature;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FeatureSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function view(): View
    {
        $features = Feature::query()
            ->withTranslations()
            ->with('featureItems.titleTranslate')
            ->get();

        $data = $features->flatMap(function ($feature) {
            return $feature->featureItems->map(function ($featureItem) use ($feature) {
                return [
                    'featureTitle' => optional($feature->titleTranslate)->ru,
                    'featureItemTitle' => optional($featureItem->titleTranslate)->ru,
                    'featureItemId' => $featureItem->id,
                ];
            });
        })->filter();

        return view('admin.exports.featureSheet', ['features' => $data]);
    }

    public function title(): string
    {
        return 'Характеристики';
    }
}
