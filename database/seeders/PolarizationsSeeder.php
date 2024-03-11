<?php

namespace Database\Seeders;

use App\Models\Polarizations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolarizationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polarization = [
            'H',
            'V'
        ];

        foreach ($polarization as $item)
        {
            Polarizations::create([
                'name' => $item,
                'status' =>1
            ]);
        }
    }
}
