<?php

namespace App\Observers;

class FilterObserver
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
        cache()->forget('apiFilters');
    }
}