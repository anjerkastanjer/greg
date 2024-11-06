<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aanvraag extends Model
{
    use HasFactory;
    protected $table = 'aanvragen';

    
    protected $fillable = [
        'oppasser_id',
        'owner_id',
        'pet_id',
        'status',
    ];

    // Definieer de relaties
    public function oppasser()
    {
        return $this->belongsTo(User::class, 'oppasser_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function pet()
    {
    return $this->belongsTo(Pet::class, 'pet_id');
    }

}
