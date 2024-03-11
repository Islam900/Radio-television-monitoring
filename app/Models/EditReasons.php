<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditReasons extends Model
{
    use HasFactory;
    protected $table = 'edit_reasons';
    protected $fillable = ['local_broadcasts_id', 'foreign_broadcasts_id','reason', 'solved_status'];

    public function local_broadcasts()
    {
        return $this->belongsTo(LocalBroadcasts::class);
    }

    public function foreign_broadcasts()
    {
        return $this->belongsTo(ForeignBroadcasts::class);
    }
}
