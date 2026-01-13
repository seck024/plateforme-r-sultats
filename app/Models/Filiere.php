<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Diplome;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function diplomes()
    {
        return $this->belongsToMany(Diplome::class);
    }
}
