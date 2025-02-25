<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // $this->call([
        //     ThemeSeeder::class,
        //     BlogSeeder::class
        // ]);

        User::factory(
            [
                "nom" => "Kouassi",
                "prenom" => "Kouakou",
                "bio" => "Je suis un développeur web",
                "avatar" => "https://picsum.photos/200",
                "email" => "test@gmail.com"
            ]
        )
            ->create();
            $this->call([
                ThemeSeeder::class,
                BlogSeeder::class,
            ]);
    }
}
