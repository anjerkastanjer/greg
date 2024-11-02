<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
        'owner_id', // This assumes a User owns the pet
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function sittingRequests()
    {
        return $this->hasMany(SittingRequest::class);
    }
}
