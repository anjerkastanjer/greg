<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    
    protected $fillable = ['pet_id', 'rating', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
{
    return $this->belongsTo(Pet::class);
}

  
}
