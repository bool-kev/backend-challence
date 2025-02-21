<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags=[
            "React",
            "Angular",
            "TailWind",
            "DevOps",
            "Security",
            "Bug"
        ];
        foreach ($tags as $tag) {
            Theme::create([
                "titre"=>$tag
            ]);
        }
    }
}
