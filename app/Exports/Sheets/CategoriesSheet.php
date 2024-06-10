<?php

namespace App\Exports\Sheets;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoriesSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function view(): View
    {
        $categories = [];

        Category::query()
            ->withTranslations()
            ->with(['subCategories' => function ($query) {
                $query->where('is_active', '=', 1)
                    ->with('titleTranslate');
            }])
            ->isActive()
            ->get()
            ->transform(function ($category) use (&$categories) {
                if (count($category->subCategories)) {
                    foreach ($category->subCategories as $subCategory) {
                        $categories[] = [
                            'id' => $category->id,
                            'title' => $category->titleTranslate?->ru,
                            'subCategoryId' => $subCategory->id,
                            'subCategoryTitle' => $subCategory->titleTranslate?->ru,
                        ];
                    }
                } else {
                    $categories[] = [
                        'id' => $category->id,
                        'title' => $category->titleTranslate?->ru,
                        'subCategoryId' => '',
                        'subCategoryTitle' => '',
                    ];
                }
            });

        return view('admin.exports.categorySheet', ['categories' => $categories]);
    }

    public function title(): string
    {
        return 'Категории';
    }
}
