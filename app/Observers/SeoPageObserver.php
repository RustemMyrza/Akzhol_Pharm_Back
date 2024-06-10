<?php

namespace App\Observers;

use App\Models\Product;

class SeoPageObserver
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

    protected function forgetCaches()
    {
        cache()->forget('apiMenus');
        cache()->forget('apiSeoInstructions');
        cache()->forget('apiSeoHome');
        cache()->forget('apiSeoCatalog');
        cache()->forget('apiSeoPaymentMethods');
        cache()->forget('apiSeoDelivery');
        cache()->forget('apiSeoAbout');
        cache()->forget('apiSeoDealers');
        cache()->forget('apiSeoContacts');

        foreach (Product::query()->pluck('id') as $productId) {
            cache()->forget('apiSeoProduct-' . $productId);
        }
    }
}
