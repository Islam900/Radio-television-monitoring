<?php

namespace Database\Seeders;

use App\Models\LocalBroadcasts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LocalBroadcastsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 364; $i++) {
            LocalBroadcasts::create([
                'stations_id' => 1,
                'report_date' => $faker->dateTimeBetween(now()->subYear(), now())->format('Y-m-d'),
                'frequency' => $faker->randomFloat(2, 80, 110),
                'program_name' => $faker->randomElement(['Azərbaycan dili haqqında', 'Fars dili haqqında', 'Gürcü dili haqqında', 'Rus dili haqqında']),
                'direction' => $faker->randomElement(['İran', 'Ermənistan', 'Gürcüstan', 'Rusiya']),
                'program_lang' => $faker->randomElement(['Azərbaycan dili', 'Fars dili', 'Gürcü dili', 'Rus dili']),
                'emfs_level' => $faker->randomFloat(2, 0, 100),
                'response_direction' => $faker->numberBetween(0, 359),
                'polarization' => $faker->randomElement(['H', 'V']),
                'response_quality' => $faker->randomElement(['Yaxşı', 'Orta', 'Zəif']),
                'note' => $faker->text(),
                'device' => $faker->word(),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }
    }
}
