<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Encadrant;
use App\Models\Etudiants;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lname',
        'tele',
        'CIN',
        'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    static function getEtudiant($user_id)
    {
        $etudiants = Etudiant::all();
        foreach($etudiants as $etudiant)
        {
            if($etudiant->user_id == $user_id)
                return $etudiant;
        }
    }

    static function getCoencadrant($user_id)
    {
        $coencadrants = Encadrant::where('type', 'nohabilite')->get();
       
        foreach($coencadrants as $coencadrant)
        {
            
            if($coencadrant->user_id == $user_id){
                return $coencadrant;
            }
                
        }
    }

    static function getEncadrant($user_id)
    {
        $encadrants = Encadrant::where('type', 'habilite')->get();
        foreach($encadrants as $encadrant)
        {
            if($encadrant->user_id == $user_id)
                return $encadrant;
        }
    }

    static function getUsers($etudiants, $encadrants)
    {
        $users = collect();
        if($encadrants != NULL)
            foreach($encadrants as $encadrant)
                $users->push( User::where('id', $encadrant->user_id)->get()[0]);
        if($etudiants != NULL) 
            foreach($etudiants as $etudiant)
                $users->push( User::where('id', $etudiant->user_id)->get()[0]);

        return $users;
    }


    public function isAdmin()
    {

        if ($this->type== 'admin') {
            return true;
          
        }

        return false;
    }


    public function isEncadrant()
    {

        if ($this->type== 'encadrant') {
            return true;
          
        }

        return false;
    }




    public function isCoEncadrant()
    {

        if ($this->type== 'co-encadrant') {
            return true;
          
        }

        return false;
    }




    public function isEtudiant()
    {

        if ($this->type== 'etudiant') {
            return true;
          
        }

        return false;
    }





}