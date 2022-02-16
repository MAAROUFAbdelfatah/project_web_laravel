<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    public function conference()
    {
        return $this->hasOne(Conference::class);
    }

    public function journal()
    {
        return $this->hasOne(Journal::class);
    }
    public function businessPlan()
    {
        return $this->belongsTo(BusinessPlan::class, 'businessPlan_id');
    }
    
}
