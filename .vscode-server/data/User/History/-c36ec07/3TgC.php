<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model 
{
    use HasFactory;

    protected $fillable = [
        'naam',            
        'eigenaar',        
        'soort',           
        'loon_per_uur',    
        'start_date',      
        'user_id' 
    ];

    // Relatie met de User
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    // Relatie met de SittingRequest
    public function sittingRequests()
    {
        return $this->hasMany(SittingRequest::class);
    }

    public function aanvragen()
    {
    return $this->hasMany(Aanvraag::class);
    }
}