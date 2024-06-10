<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function saved(Category $category)
    {
        $this->updateOtherCategories($category);
        $this->forgetCaches();
    }

    public function created(Category $category)
    {
        $this->updateOtherCategories($category);
        $this->forgetCaches();
    }

    public function updated(Category $category)
    {
        $this->updateOtherCategories($category);
        $this->forgetCaches();
    }

    public function deleted()
    {
        $this->forgetCaches();
        if (!Category::query()->isImportant()->count()){
            Category::query()->first()?->update(['is_important' => 1]);
        }
    }

    protected function updateOtherCategories(Category $category)
    {
        if ($category->is_important) {
            Category::query()->where('id', '<>', $category->id)->update(['is_important' => 0]);

            if (!Category::query()->isImportant()->count()){
                Category::query()->first()?->update(['is_important' => 1]);
            }
        }
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
