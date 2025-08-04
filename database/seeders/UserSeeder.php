<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected array $users = [
        ['name' => 'Иван Иванов', 'email' => 'ivan.ivanov@example.com'],
        ['name' => 'Петр Петров', 'email' => 'petr.petrov@example.com'],
        ['name' => 'Мария Сидорова', 'email' => 'maria.sidorova@example.com'],
        ['name' => 'Алексей Смирнов', 'email' => 'alexey.smirnov@example.com'],
        ['name' => 'Ольга Кузнецова', 'email' => 'olga.kuznetsova@example.com'],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->users as $user) {
            if (!User::where('email', $user['email'])->exists()) {
                User::create(['name' => $user['name'], 'email' => $user['email']]);
            }
        }
    }
}
