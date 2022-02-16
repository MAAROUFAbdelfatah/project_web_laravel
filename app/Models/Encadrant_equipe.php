<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encadrant_equipe extends Model
{
    use HasFactory;
    static function isAlreadyExist($equipe_id, $encadrant_id)
    {
        $equipe_encadrants = Encadrant_equipe::all();

        foreach($equipe_encadrants as $equipe_encadrant)
        {
            if($equipe_encadrant->equipe_id == $equipe_id && $equipe_encadrant->encadrant_id == $encadrant_id)
                return TRUE;
        }
        return FALSE;
        
    }


    static function getEncadrant_equipe($equipe_id, $encadrant_id)
    {
        $equipe_encadrants = Encadrant_equipe::all();

        foreach($equipe_encadrants as $equipe_encadrant)
        {
            if($equipe_encadrant->equipe_id == $equipe_id && $equipe_encadrant->encadrant_id == $encadrant_id)
                return $equipe_encadrant;
        }
        return NULL;
    }
}
