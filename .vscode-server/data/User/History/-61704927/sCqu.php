<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oppasser extends Model
{
    use HasFactory;

    // Define the table if it doesn't follow Laravel's naming convention
    protected $table = 'oppasser';

    // Specify the fillable attributes
    protected $fillable = [
        'user_id', // Foreign key to users table
        'naam',
        'soort_dier',
        'loon',
        'profile_image',
    ];
    
    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
