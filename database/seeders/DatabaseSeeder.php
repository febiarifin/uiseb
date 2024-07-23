<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Page;
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
            'email' => 'admin@gmail.com',
            'password' => Hash::make(123456),
            'type' => User::TYPE_ADMIN,
        ]);

        User::create([
            'name' => 'EDITOR',
            'email' => 'editor@gmail.com',
            'password' => Hash::make(123456),
            'type' => User::TYPE_EDITOR,
        ]);

        User::create([
            'name' => 'REVIEWER',
            'email' => 'reviewer@gmail.com',
            'password' => Hash::make(123456),
            'type' => User::TYPE_REVIEWER,
        ]);

        User::create([
            'name' => 'Febi Arifin',
            'first_name' => 'Febi',
            'last_name' => 'Arifin',
            'email' => 'febi@gmail.com',
            'password' => Hash::make(123456),
            'type' => User::TYPE_PESERTA,
            'is_email_verified' => 1,
        ]);

        Page::create([
            'name' => '2024'
        ]);


        $names = ["Peserta Seminar Mahasiswa", "Penyeminar Seminar Mahasiswa", "Peserta Seminar Umum", "Peserta Seminar Internasional"];
        $is_papers = [0, 1, 0, 1];
        $amounts = [50000, 100000, 150000, 200000];
        for ($i=0; $i < count($names); $i++) {
            Category::create([
                'name' => $names[$i],
                'description' => fake()->paragraph(10),
                'amount' => $amounts[$i],
                'is_paper' => $is_papers[$i],
            ]);
        }
    }
}
