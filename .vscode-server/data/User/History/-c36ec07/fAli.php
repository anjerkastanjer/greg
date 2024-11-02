<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pet extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'pet_id',
        'start_date',
        'end_date',
        'status', // e.g., pending, accepted, completed
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sittingRequests()
    {
        return $this->hasMany(SittingRequest::class);
    }
}
