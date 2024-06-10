<?php

namespace App\Observers;

class UserObserver
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
        cache()->forget('forAdminUsersCount');
        cache()->forget('forDeveloperUsersCount');
        cache()->forget('forDeveloperUsers');
        cache()->forget('forAdminUsers');
    }
}
