<?php

namespace Database\Seeders;

use App\Models\ProgramLanguages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramLanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            'Azərbaycan',
            'Fars',
            'Fars-Azəri',
            'Rus',
            'Gürcü',
            'Erməni',
            'Orta Asiya dilləri',
            'Təyin edilməyib'
        ];

        foreach ($array as $item)
        {
            ProgramLanguages::create([
                'name' => $item,
                'status' =>1
            ]);
        }
    }
}
