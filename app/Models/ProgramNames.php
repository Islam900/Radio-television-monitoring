<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramNames extends Model
{
    use HasFactory;
    protected $table = 'program_names';
    protected $fillable = ['name', 'status'];

    public function frequencies()
    {
        return $this->hasMany(Frequencies::class);
    }

    public function local_broadcasts()
    {
        return $this->hasMany(LocalBroadcasts::class);
    }

    public function foreign_broadcasts()
    {
        return $this->hasMany(LocalBroadcasts::class);
    }
}
