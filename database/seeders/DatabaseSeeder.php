<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('task_statuses')->insert(['name' => 'новый', 'created_at' => '2025-09-02']);
        DB::table('task_statuses')->insert(['name' => 'в работе', 'created_at' => '2025-09-02']);
        DB::table('task_statuses')->insert(['name' => 'на тестировании', 'created_at' => '2025-09-02']);
        DB::table('task_statuses')->insert(['name' => 'завершен', 'created_at' => '2025-09-02']);
        DB::table('tasks')->insert(['title' => 'Исправить ошибку в какой-нибудь строке', 'status_id' => 2, 'created_by_id' => 1, 'assigned_to_id' => 2,'created_at' => '2025-09-02']);
    }
}
