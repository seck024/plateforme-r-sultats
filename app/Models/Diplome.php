<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Filiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function diplomes()
    {
        return $this->belongsToMany(Diplome::class);
    }
}
class Diplome extends Model
{
    protected $fillable = ['nom', 'filiere_id'];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}

