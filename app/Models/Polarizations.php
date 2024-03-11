<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Polarizations extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'polarizations';
    protected $fillable = ['name', 'status'];

    public function frequencies()
    {
        return $this->hasMany(Frequencies::class);
    }

}
