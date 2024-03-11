<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramLocations extends Model
{
    use HasFactory;
    protected $table = 'program_locations';
    protected $fillable = ['name', 'status'];

    public function frequencies()
    {
        return $this->hasMany(Frequencies::class);
    }
}
