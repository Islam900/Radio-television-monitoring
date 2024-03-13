<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForeignBroadcasts extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'foreign_broadcasts';

    protected $fillable = [
        'report_number',
        'stations_id',
        'frequencies_id',
        'report_date',
        'program_names_id',
        'directions_id',
        'program_languages_id',
        'program_locations_id',
        'emfs_level_in',
        'emfs_level_out',
        'response_direction_in',
        'response_direction_out',
        'polarization',
        'response_quality',
        'sending_from',
        'cons_or_peri',
        'note',
        'device'
    ];

    public function stations()
    {
        return $this->belongsTo(Stations::class);
    }

    public function edit_reasons()
    {
        return $this->hasMany(EditReasons::class);
    }

    public function frequencies()
    {
        return $this->belongsTo(Frequencies::class);
    }

    public function program_names()
    {
        return $this->belongsTo(ProgramNames::class);
    }

    public function program_locations()
    {
        return $this->belongsTo(ProgramLocations::class);
    }

    public function directions()
    {
        return $this->belongsTo(Directions::class);
    }

    public function program_languages()
    {
        return $this->belongsTo(ProgramLanguages::class);
    }

    public function polarizations()
    {
        return $this->belongsTo(Polarizations::class);
    }
}
