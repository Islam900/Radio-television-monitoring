<?php

namespace Database\Seeders;

use App\Models\Directions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            'Teleqüllə',
            'Günəşli',
            'Rusiya',
            'İran',
            'Gürcüstan',
            'Ermənistan',
            'Orta Asiya'
        ];

        foreach ($array as $item)
        {
            Directions::create([
                'name' => $item,
                'status' => 1
            ]);
        }

    }
}
