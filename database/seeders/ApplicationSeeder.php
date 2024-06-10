<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * php artisan db:seed --class=ApplicationSeeder
     *
     */
    public function run(): void
    {
        Application::factory()->count(5)->create();
    }
}
