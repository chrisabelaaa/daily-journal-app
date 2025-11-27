<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'title', 'description', 'due_date', 'deadline', 'status', 'archived_at'
    ];
    
    protected $casts = [
        'archived_at' => 'datetime',
    ];
}
