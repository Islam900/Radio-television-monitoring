<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramLanguages extends Model
{
    use HasFactory;
    protected $table = 'program_languages';
    protected $fillable = ['name', 'status'];

    public function frequencies()
    {
        return $this->hasMany(Frequencies::class);
    }
}
