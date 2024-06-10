<?php

namespace App\Observers;

use App\Models\Category;

class SubCategoryObserver
{
    public function saved()
    {
        $this->forgetCaches();
    }

    public function created()
    {
        $this->forgetCaches();
    }

    public function updated()
    {
        $this->forgetCaches();
    }

    public function deleted()
    {
        $this->forgetCaches();
    }

    protected function forgetCaches(){
        cache()->forget('categoriesCount');
        cache()->forget('productCategories');
        cache()->forget('categoryFilters');
        cache()->forget('apiCategories');
        cache()->forget('apiNewCategories');
        cache()->forget('apiNewCatalogCategories');
        cache()->forget('apiFooterCategories');
        cache()->forget('apiImportantCategory');

        foreach (Category::query()->pluck('id') as $categoryId) {
            cache()->forget('apiSimilarProducts-' . $categoryId);
        }
    }
}
