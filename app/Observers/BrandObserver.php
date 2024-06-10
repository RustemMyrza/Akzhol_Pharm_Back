<?php

namespace App\Observers;

class BrandObserver
{
    public function saved()
    {
        cache()->forget('productBrands');
    }

    public function created()
    {
        cache()->forget('productBrands');
    }

    public function updated()
    {
        cache()->forget('productBrands');
    }

    public function deleted()
    {
        cache()->forget('productBrands');
    }
}
