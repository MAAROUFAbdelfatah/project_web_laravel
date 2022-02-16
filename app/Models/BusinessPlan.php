<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPlan extends Model
{
    use HasFactory;
    // public function project()
    // {
    //     return $this->belongsTo(Project::class);
    // }
    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }
    public function taches()
    {
        return $this->hasMany(Tache::class, 'businessPlan_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'businessPlan_id');
    }
}
