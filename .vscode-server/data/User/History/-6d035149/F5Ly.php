<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aanvraag extends Model
{
    use HasFactory;

    // Vul de velden die massaal toewijsbaar zijn
    protected $fillable = [
        'oppasser_id',
        'owner_id',
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
}
