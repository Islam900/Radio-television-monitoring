<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Polarizations;
use App\Models\ProgramLanguages;
use App\Models\ProgramLocations;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(StationsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(ProgramNamesSeeder::class);
        $this->call(ProgramLanguagesSeeder::class);
        $this->call(DirectionsSeeder::class);
        $this->call(ProgramLocationsSeeder::class);
        $this->call(PolarizationsSeeder::class);

    }
}
