<?php

namespace App\Exports\Sheets;

use App\Models\Filter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FilterSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function view(): View
    {
        $filters = Filter::query()
            ->withTranslations()
            ->with('filterItems.titleTranslate')
            ->get();

        $data = $filters->flatMap(function ($filter) {
            return $filter->filterItems->map(function ($filterItem) use ($filter) {
                return [
                    'filterTitle' => optional($filter->titleTranslate)->ru,
                    'filterItemTitle' => optional($filterItem->titleTranslate)->ru,
                    'filterItemId' => $filterItem->id,
                ];
            });
        })->filter();

        return view('admin.exports.filterSheet', ['filters' => $data]);
    }

    public function title(): string
    {
        return 'Фильтр';
    }
}
