<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Equipe;
use App\Models\Encadrant;
use App\Models\Etudiant;
use App\Models\User;
use App\Models\businessPlan;
use App\Models\Encadrant_equipe;
use App\Traits\FilesTrait;
use Illuminate\Support\Facades\Auth;    // Must Must use

class EquipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('etudiant');
    }
    use FilesTrait;
    public function index()
    {
        
        if (Auth::user()->isEncadrant())
             $equipes = User::getEncadrant(Auth::user()->id)->equipes;
        elseif (Auth::user()->isCoEncadrant())
            $equipes = User::getCoencadrant(Auth::user()->id)->equipes;
        elseif(Auth::user()->isEtudiant())
        {
            $equipes = collect();
            $equipes->push(User::getEtudiant(Auth::user()->id)->equipe);

        }
        else
            $equipes = Equipe::all();
        


        return view('admin.equipes.index', compact('equipes'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.equipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $equipe = new Equipe();
        $equipe_encadrant = new Encadrant_equipe();
        $validator = Validator::make($request->all(), [
            'nom' => 'required|unique:equipes',
            'description' => 'required',
            'image' => 'file|max:3028'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
       
        if($request->file('image') != null){
            $image = $request->file('image');
            if(!$this->isImage($image))
                return redirect()->back()->with('error', "The file is not an image.");
            $image = $this->saveFile($request->file('image')  ,'images/equipes');
            $equipe->image = $image;
        }
        else
            $equipe->image = "default.jpg";
        
        $equipe->nom = $request->input('nom');
        $equipe->description = $request->input('description');
        
        $equipe->save();
        if(Auth::user()->isEncadrant())
        {
            $equipe_encadrant->equipe_id = $equipe->id;        
            $equipe_encadrant->encadrant_id = User::getEncadrant(Auth::user()->id)->id;  
            $equipe_encadrant->save(); 
        }
            
        return redirect('admin/equipes/create')->with('success', 'Equipe est ajouter');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $equipe = Equipe::find($id);
        $encadrants = $equipe->ecadrants;
        $etudiants = $equipe->etudiants;

        $members = User::getUsers($etudiants, $encadrants);

        return view('admin.equipes.show', compact('equipe', 'members'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $equipe = Equipe::find($id);
        return view('admin.equipes.edit', compact('equipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $equipe = Equipe::find($id);

        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'description' => 'required',
            'image' => 'file|max:3028'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        if($request->file('image') != null){
            $image = $request->file('image');
            if(!$this->isImage($image))
                return redirect()->back()->with('error', "The file is not an image.");
            $image = $this->saveFile($request->file('image')  ,'images/equipes');
            if($equipe->image != "default.jpg")
                $this->deleteFile($equipe->image, 'images/equipes');
            $equipe->image = $image;
        }

        $equipe->nom = $request->input('nom');
        $equipe->description = $request->input('description');

        $equipes = Equipe::where('nom',  $equipe->nom)->get();

        if(count($equipes) > 1)
            return redirect('admin/equipes/'.$id.'/edit')->with('error', "The name has already been taken.");

        $equipe->save();
        return redirect('admin/equipes')->with('success', "Equipe $equipe->nom est modifier");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bps_deleter = new BusniessPlansController();
        $equipe = Equipe::find($id);
        $users_deleter = new EquipesController();
        $etudiants = $equipe->etudiants;
        $encadrants = $equipe->ecadrants;
        $users = User::getUsers($etudiants, $encadrants);
        foreach($users as $user)
            $users_deleter->deleteMember($equipe->id, $user->id);
        $pbs = $equipe->businessPlans;
        foreach($pbs as  $pb)
            $bps_deleter->destroy($pb->id);
        if($equipe->image != "default.jpg")
            $this->deleteFile($equipe->image, 'images/equipes');
        $equipe->delete();
        return redirect('admin/equipes')->with('success', "Equipe $equipe->nom est supprimer");
    }


    public function addMember($id)
    {
        $equipe = Equipe::find($id);
        return view('admin.equipes.members.create')->with('equipe', $equipe);
    }

    public function deleteMember($equipe_id, $member_id)
    {
        $equipe = Equipe::find($equipe_id);
        $user = User::find($member_id);
        if($user->type == "etudiant")
        {
            $etudiant = User::getEtudiant($user->id);
            $etudiant->equipe_id = NULL;
            $etudiant->save();
            return redirect('admin/equipes/'.$equipe->id)->with('success', "Etudiant $user->name est supprimer au Equipe $equipe->nom");
        }
        elseif($user->type == "encadrant")
        {
            $encadrant = User::getEncadrant($user->id);
            $encadrant_equipe = Encadrant_equipe::getEncadrant_equipe($equipe_id, $encadrant->id);
            $encadrant_equipe->delete();
            return redirect('admin/equipes/'.$equipe->id)->with('success', "Encadrant $user->name est supprimer au Equipe $equipe->nom");
        }
        elseif($user->type == "co-encadrant")
        {
            $coencadrant = User::getCoencadrant($user->id);
            $encadrant_equipe = Encadrant_equipe::getEncadrant_equipe($equipe_id, $coencadrant->id);
            $encadrant_equipe->delete();
            return redirect('admin/equipes/'.$equipe->id)->with('success', "Co-encadrant $user->name est supprimer au Equipe $equipe->nom");
        }
    }

    public function storeMember(Request $request)
    {

        $id = $request->input('id');
        $email = $request->input('email');

        $equipe = Equipe::find($id);
            
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/equipes/'.$equipe->id.'/members/create')
                        ->withErrors($validator)
                        ->withInput();
        }
       
        $members = User::where('email', $email)->get();
        if(count($members) > 0){
            $member = $members[0];
            if ($member->type == "etudiant")
            {
                $etudiant = User::getEtudiant($member->id);
                if($etudiant->equipe_id != NULL){
                    if($etudiant->equipe_id == $equipe->id)
                        return redirect('admin/equipes/'.$equipe->id.'/members/create')->with('error', "Etudiant $member->name est deja exist dans cette equipe ");
                    return redirect('admin/equipes/'.$equipe->id.'/members/create')->with('error', "Etudiant $member->name est deja exist dans un autre equipe ");
                }
                    
                $etudiant->equipe_id = $equipe->id;
                $etudiant->save();
                return redirect('admin/equipes/'.$equipe->id.'/members/create')->with('success', "Etudiant $member->name est ajouter au Equipe $equipe->nom");
            }
            else if ($member->type == "encadrant")
            {
                $encadrant = User::getEncadrant($member->id);
                $equipe_encadrant = new Encadrant_equipe();
                if(Encadrant_equipe::isAlreadyExist($equipe->id, $encadrant->id))
                    return redirect('admin/equipes/'.$equipe->id.'/members/create')->with('error', "Encadrant $member->name est deja exist dans cette equipe ");
                $equipe_encadrant->equipe_id = $equipe->id;        
                $equipe_encadrant->encadrant_id = $encadrant->id;  
                $equipe_encadrant->save(); 
                return redirect('admin/equipes/'.$equipe->id.'/members/create')->with('success', "Encadrant $member->name est ajouter au Equipe $equipe->nom");        
                 
            }
            else if ($member->type == "co-encadrant")
            {
                 
                $coencadrant = User::getCoencadrant($member->id);
                $equipe_encadrant = new Encadrant_equipe();
                if(Encadrant_equipe::isAlreadyExist($equipe->id, $coencadrant->id))
                    return redirect('admin/equipes/'.$equipe->id.'/members/create')->with('error', "Co-encadrant $member->name est deja exist dans cette equipe ");
                $equipe_encadrant->equipe_id = $equipe->id;        
                $equipe_encadrant->encadrant_id = $coencadrant->id;  
                $equipe_encadrant->save(); 
                return redirect('admin/equipes/'.$equipe->id.'/members/create')->with('success', "Co-encadrant $member->name est ajouter au Equipe $equipe->nom");
            }
        }

        
        
        return redirect('admin/equipes/'.$equipe->id.'/members/create')->with('error', "The email does not exist.");
        
 
    }
}
