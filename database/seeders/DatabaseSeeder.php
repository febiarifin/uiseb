<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'ADMINISTRATOR',
            'email' => 'admin@uiseb.feb-unsiq.ac.id',
            'password' => Hash::make(123456),
            'type' => User::TYPE_ADMIN,
        ]);
    }
}
