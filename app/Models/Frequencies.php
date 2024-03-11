<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frequencies extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'frequencies';
    protected $fillable = ['value', 'program_names_id','directions_id','program_locations_id','program_languages_id','polarizations_id' ,'status'];

    public function stations()
    {
        return $this->belongsToMany(Stations::class);
    }

    public function program_names()
    {
        return $this->belongsTo(ProgramNames::class);
    }

    public function directions()
    {
        return $this->belongsTo(Directions::class);
    }

    public function program_locations()
    {
        return $this->belongsTo(ProgramLocations::class);
    }

    public function program_languages()
    {
        return $this->belongsTo(ProgramLanguages::class);
    }

    public function polarizations()
    {
        return $this->belongsTo(Polarizations::class);
    }

    public function local_broadcasts()
    {
        return $this->hasMany(LocalBroadcasts::class);
    }

    public function foreign_broadcasts()
    {
        return $this->hasMany(ForeignBroadcasts::class);
    }
}
