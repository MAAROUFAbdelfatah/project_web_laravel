<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encadrant extends Model
{
    use HasFactory;
    public function equipes()
    {
        return $this->belongsToMany(Equipe::class, 'encadrant_equipes');
    }
}
