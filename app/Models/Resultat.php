<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    protected $fillable = [
        'etudiant_id',
        'annee_id',
        'statut',
        'valide',
        'publie'
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
