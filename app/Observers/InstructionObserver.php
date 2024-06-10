<?php

namespace App\Observers;

use App\Models\Instruction;

class InstructionObserver
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
        $limit = intVal(ceil(Instruction::query()->count() / Instruction::DEFAULT_API_PAGINATE));
        for ($index = 1; $index <= $limit; $index++) {
            cache()->forget('apiInstructions_' . $index);
        }
    }
}
