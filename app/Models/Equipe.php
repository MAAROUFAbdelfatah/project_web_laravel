<?php

namespace App\Models;
use App\Models\Encadrant;
use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;
    public function businessPlans()
    {
        return $this->hasMany(BusinessPlan::class);
    }
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function ecadrants()
    {
        return $this->belongsToMany(Encadrant::class, 'encadrant_equipes');
    }
}
