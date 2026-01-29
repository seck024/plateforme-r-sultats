<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    protected $fillable = [
        'annee',
        'diplome_id'
    ];

    public function diplome()
    {
        return $this->belongsTo(Diplome::class);
    }
}
