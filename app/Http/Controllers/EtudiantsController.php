<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Traits\FilesTrait;
class EtudiantsController extends Controller
{
    use FilesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('admin');
    }
    public function index()
    {
        $etudiants = User::where('type', 'etudiant')->get();
        return view('admin.etudiants.index', compact('etudiants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.etudiants.create');    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $validator = Validator::make($request->all(), [
            
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|unique:users|max:255',
            'tele' => 'required|unique:users|regex:/(06)[0-9]{8}/',
            'CIN' => 'required|unique:users|max:255',
            'CNE'=> 'required|unique:etudiants',
            'appoger'=> 'required|unique:etudiants'
        ]);

        if ($validator->fails()) {
            return redirect('admin/etudiants/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        if($request->file('image') != null){
            $image = $request->file('image');
            if(!$this->isImage($image))
                return redirect()->back()->with('error', "The file is not an image.");
            $image = $this->saveFile($request->file('image')  ,'images/users');
            $user->image = $image;
        }else
            $user->image = "default.jpg";

        $user->name = $request->input('fname');
        $user->lname = $request->input('lname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->CIN = $request->input('CIN');
        $user->type = $request->input('type');
        $user->tele = $request->input('tele');
        $user->save();
        $user1 = User::where('email', $user->email)->get(); 
        $etudiant = new Etudiant();
        $etudiant->CNE = $request->input('CNE');
        $etudiant->appoger = $request->input('appoger');
        $etudiant->user_id = $user1[0]->id;
        $etudiant->save();
        return redirect('admin/etudiants/create')->with('success', 'Etudiant est ajouter');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $etudiant = Etudiant::where('user_id', $id)->get()[0];
        return view('admin.etudiants.edit',compact('user', 'etudiant'));
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
        $user = User::find($id);
        $users = User::all();
        $etudiant = Etudiant::where('user_id', $id)->get();
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|unique:users|max:255',
            'tele' => 'required|unique:users|regex:/(06)[0-9]{8}/',
            'CIN' => 'required|unique:users|max:255',
            'CNE'=> 'required|unique:etudiants',
            'appoger'=> 'required|unique:etudiants'
        ]);
        $etudiants = Etudiant::all();

        foreach($users as $u)
        {
            if($u->id != $id)
            {
                if($u->email == $request->input('email'))
                    return redirect('admin/etudiants/'.$id.'/edit')->with('error', "The email has already been taken.");
                if($u->CIN == $request->input('CIN'))
                    return redirect('admin/etudiants/'.$id.'/edit')->with('error', "The cin has already been taken.");
                if($u->tele == $request->input('tele'))
                    return redirect('admin/etudiants/'.$id.'/edit')->with('error', "The tele has already been taken.");
            }   
        }

        foreach($etudiants as $e)
        {
            if($e->CNE != $etudiant[0]->CNE)
            {
                if($e->CNE == $request->input('CNE'))
                    return redirect('admin/etudiants/'.$id.'/edit')->with('error', "The CNE has already been taken.");
                if($e->appoger == $request->input('appoger'))
                    return redirect('admin/etudiants/'.$id.'/edit')->with('error', "The appoger has already been taken.");
            }   
        }

        if($request->file('image') != null){
            $image = $request->file('image');
            if(!$this->isImage($image))
                return redirect()->back()->with('error', "The file is not an image.");
            $image = $this->saveFile($request->file('image')  ,'images/users');
            if($user->image != "default.jpg")
                $this->deleteFile($user->image, 'images/users');
            $user->image = $image;
        }
        if($request->input('password') != null)
            $user->password = Hash::make($request->input('password'));
        $user->name = $request->input('fname');
        $user->lname = $request->input('lname');
        $user->email = $request->input('email');
        $user->CIN = $request->input('CIN');
        $user->type = $request->input('type');
        $user->tele = $request->input('tele');
        $user->save();

        $etudiant[0]->CNE = $request->input('CNE');
        $etudiant[0]->appoger = $request->input('appoger');
        $etudiant[0]->save();
        return redirect('admin/etudiants')->with('success', "Encadrant $user->name $user->lname est modifier");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $etu_user = User::find($id);
        $etudiants = Etudiant::all();
        if($etu_user->image != null && $etu_user->image != "default.jpg")
            $this->deleteFile($etu_user->image, 'images/users');
        foreach ($etudiants as $etudiant)
        {
            if($etudiant->user_id == $id)
            {
                $etudiant->delete();
                break;
            }
        }
        $etu_user->delete();
        return redirect('admin/etudiants')->with('success', "Etudiant $etu_user->name $etu_user->lname est supprimer");
    
    }
}
