<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
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

        // User::create([
        //     'name' => 'Febi Arifin',
        //     'first_name' => 'Febi',
        //     'last_name' => 'Arifin',
        //     'email' => 'febi@gmail.com',
        //     'password' => Hash::make(123456),
        //     'type' => User::TYPE_PESERTA,
        //     'is_email_verified' => 1,
        // ]);

        Page::create([
            'name' => '2024',
            'about_1' => "<div>UNSIQ International Symposium on Economics and Busines with a theme of 'SMEs Competitiveness in Digital Era' will be held at Wonosobo, Central Java, Indonesia on December 20, 2024 (08.00-15.00 Jakarta Time) at Faculty of Economic and Busines Universitas Sains Al-Qur'an, Wonosobo.</div>",
            'about_2' => "<div>UNSIQ International Symposium on Economics and Busines will be held at Wonosobo, Central Java, Indonesia on December 20, 2024 (08.00-15.00 Jakarta Time) at Faculty of Economic and Busines Universitas Sains Al-Qur'an, Wonosobo. The UISEB 2024 had been well received by the research and academic community both in national and international scale. The conference will be held in HYBRID MODE. The presentation of speakers is carried out directly on site and via Zoom. The theme of UISEB 2024 is SMEs Competitiveness in Digital Era.</div>",
            // 'image_1' => 'storage/images/qMto88FBDQJn5eTwJicGmcCAYmm4EvgB7jwnBHll.jpg',
            // 'image_2' => 'storage/images/W7FDJJz3PKMrcfBVFu3uMG6x1yd1mLl3kWEClWS1.png',
            // 'image_3' => 'storage/images/4B4qj0bieF9UN93CI1lIlz7m05pOHuz2VKvfwAnh.jpg',
            'scope' => "<ol><li>Material Sciences for Environment and Energy</li><li>&nbsp;Sensor and Biosensor</li><li>&nbsp;Green Synthesis Organic Compounds</li><li>&nbsp;Solar and Renewable Energy</li><li>&nbsp;Nanostructured Materials</li><li>&nbsp;Biotechnology</li><li>&nbsp;Functional Material in Pharmaceutical Sciences</li><li>&nbsp;Nanopharmacy</li><li>&nbsp;Data Science</li><li>&nbsp;Applied Statistics</li><li>&nbsp;Other topics related to Science, Technology and Data Science</li></ol>",
            'submission' => "<ol><li>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe eum quibusdam architecto commodi perferendis aspernatur consequuntur eos esse debitis ex, praesentium consequatur expedita atque molestias ratione quod explicabo aperiam asperiores.</li><li>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe eum quibusdam architecto commodi perferendis aspernatur consequuntur eos esse debitis ex, praesentium consequatur expedita atque molestias ratione quod explicabo aperiam asperiores.</li><li>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe eum quibusdam architecto commodi perferendis aspernatur consequuntur eos esse debitis ex, praesentium consequatur expedita atque molestias ratione quod explicabo aperiam asperiores.</li></ol>",
            'status' => Page::ENABLE,
        ]);


        // $names = ["Peserta Seminar Mahasiswa", "Penyeminar Seminar Mahasiswa", "Peserta Seminar Umum", "Peserta Seminar Internasional"];
        // $is_papers = [0, 1, 0, 1];
        // $amounts = [50000, 100000, 150000, 200000];
        // for ($i=0; $i < count($names); $i++) {
        //     Category::create([
        //         'name' => $names[$i],
        //         'description' => fake()->paragraph(10),
        //         'amount' => $amounts[$i],
        //         'is_paper' => $is_papers[$i],
        //     ]);
        // }

        Setting::create();
    }
}
