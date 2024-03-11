<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrequenciesStations extends Model
{
    use HasFactory;
    protected $table = 'frequencies_stations';
    protected $fillable = ['frequencies_id', 'stations_id'];
}
