<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directions extends Model
{
    use HasFactory;

    protected $table = 'directions';
    protected $fillable = ['name', 'status'];

    public function frequencies()
    {
        return $this->hasMany(Frequencies::class);
    }

}
