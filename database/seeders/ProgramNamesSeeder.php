<?php

namespace Database\Seeders;

use App\Models\ProgramNames;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            'Daşıyıcı siqnal',
            'VARZESH',
            'ARDABİL',
            'MAAREF',
            'Javan',
            'DVB-T',
            'İRAN',
            'GİLAN',
            'EGHTESAD',
            'QURAN',
            'IRIB Azeri Radio WS',
            'SALAMAT',
            'PAYAM',
            'FARHANG',
            'İrib Azəri ws',
            'DVBT 2',
            'GR 1 Radio Erti',
            'Radio İmedi ',
            'DVB-T2',
            'Aran',
            'Yerevan FM  ',
            'GT FM Radio Georgian Times',
            'Mshvidi Radio - M7 ',
            'Star FM',
            'Avto FM',
            'Radio  Commersant  FM',
            'Muza FM',
            'Tbilisi FM',
            'Kubrik FM',
            'Radio 4  FM',
            'Uçnobi FM',
            'Şokoladi FM',
            'Abxaz FM',
            'Şanson FM',
            'Çveneburi FM',
            'Vinilo FM',
            'Beat FM',
            'AG  FM',
            'GR 2 Radio Ori - Kartuli Radio',
            'Siti FM',
            'Hayastani hanrayin radio',
            'Radio Positive FM',
            'İveriya FM',
            'Radio İmedi',
            'Yerevan FM',
            'Radio Fortuna',
            'Voice FM',
            'Sakartvelos FM',
            'Şərqi Azərbaycan',
            'Rubas',
            'TV-Kaspiy',
            'Yujdaq',
            'Daqestan',
            'Assa',
            'Zvezda',
            'Avto ',
            'Priboy',
            'Sedmoye nebo',
            'Vatan',
            'Vesti',
            'Rossiya',
            'Mayak',
            'Gürcüstan radiosu',
            'Radio İveriya',
            'Radio Maestro',
            'Radio Ardaidardo',
            'Təyin edilməyib'
        ];

        foreach ($array as $item)
        {
            ProgramNames::create([
                'name' => $item,
                'status' => 1
            ]);
        }
    }
}
