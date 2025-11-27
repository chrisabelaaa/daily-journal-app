<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods for status
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => '#ffc107',      // Yellow
            'in_progress' => '#007bff',  // Blue  
            'done' => '#28a745',         // Green
            default => '#6c757d'         // Gray
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'done' => 'Done',
            default => 'Unknown'
        };
    }
}
