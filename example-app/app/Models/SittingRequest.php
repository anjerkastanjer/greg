<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SittingRequest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'pet_id',
        'start_date',
        'end_date',
        'status', // e.g., pending, accepted, completed
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
