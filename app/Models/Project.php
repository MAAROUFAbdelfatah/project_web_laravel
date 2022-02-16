<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function businessPlan()
    {
        return $this->hasOne(BusinessPlan::class);
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }
    public function tache()
    {
        return $this->hasMany(Tache::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
