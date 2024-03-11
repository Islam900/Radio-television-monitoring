<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Stations extends Model
{
    use HasFactory;
    protected $table = 'stations';
    protected $fillable = [
        'station_name',
        'coordinate_N',
        'coordinate_E',
        'status'
    ];

    // RELATIONS
    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function local_broadcasts()
    {
        return $this->hasMany(LocalBroadcasts::class);
    }

    public function foreign_broadcasts()
    {
        return $this->hasMany(ForeignBroadcasts::class);
    }

    public function frequencies()
    {
        return $this->belongsToMany(Frequencies::class);
    }

}
