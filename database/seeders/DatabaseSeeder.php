<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Status::create(['title' => 'Новая']);
        Status::create(['title' => 'В процессе']);
        Status::create(['title' => 'Завершена']);
        Status::create(['title' => 'Отменена']);

        User::create([
            'firstname' => 'Admin',
            'middlename' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
            'login' => 'administrator',
            'password' => Hash::make('administrator'),
            'tel' => '+79999999999',
            'role' => 'admin',
        ]);
    }
}
