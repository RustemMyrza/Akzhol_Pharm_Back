<?php

namespace App\Observers;

class CountryObserver
{
    public function saved()
    {
        cache()->forget('productCountries');
    }

    public function created()
    {
        cache()->forget('productCountries');
    }

    public function updated()
    {
        cache()->forget('productCountries');
    }

    public function deleted()
    {
        cache()->forget('productCountries');
    }
}
