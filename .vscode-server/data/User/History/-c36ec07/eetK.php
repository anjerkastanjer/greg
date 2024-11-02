<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model // Hoofdlettergebruik in de class naam
{
    use HasFactory;

    protected $fillable = [
        'naam',            // Aangepast naar de kolomnamen in de migratie
        'eigenaar',        // Aangepast naar de kolomnamen in de migratie
        'soort',           // Aangepast naar de kolomnamen in de migratie
        'loon_per_uur',    // Aangepast naar de kolomnamen in de migratie
        'start_date',      // Aangepast naar de kolomnamen in de migratie
    ];

    // Relatie met de User
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); // Assuming user_id is the foreign key
    }

    // Relatie met de SittingRequest
    public function sittingRequests()
    {
        return $this->hasMany(SittingRequest::class);
    }
}