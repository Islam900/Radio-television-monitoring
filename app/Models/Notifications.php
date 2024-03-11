<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'notifications';
    protected $fillable = ['sender', 'receiver', 'l_id', 'f_id', 'content', 's_read', 'r_read'];
}
