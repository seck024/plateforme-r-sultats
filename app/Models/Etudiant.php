<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = ['matricule', 'nom', 'prenom', 'diplome_id'];

    public function diplome()
    {
        return $this->belongsTo(Diplome::class);
    }

    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    public function resultat()
    {
        return $this->hasOne(Resultat::class);
    }
}
