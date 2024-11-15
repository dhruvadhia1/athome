<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'category', 'price', 'duration', 'location_type', 'image', 'status'
    ];

    // Define relationships if any
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

