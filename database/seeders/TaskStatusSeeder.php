<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['новый', 'в работе', 'на тестировании', 'завершен'] as $name) {
            TaskStatus::firstOrCreate(['name' => $name]);
        }
    }
}
