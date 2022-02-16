<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Encadrant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Traits\FilesTrait;
use Illuminate\Support\Facades\Hash;
class EncadrantsController extends Controller
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
        $encadrants = User::where('type', 'encadrant')->get();
        return view('admin.encadrants.index', compact('encadrants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.encadrants.create');
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
            'CIN' => 'required|unique:users|max:8',
            'image' => 'file|max:3028',

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
            $image = $this->saveFile($request->file('image')  ,'images/users');
            $user->image = $image;
        }
        else
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
        $encadrant = new Encadrant();
        $encadrant->type = "habilite";
        $encadrant->user_id = $user1[0]->id;
        $encadrant->save();
        return redirect('admin/encadrants/create')->with('success', 'Encadrant est ajouter');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $encadrant = User::find($id);
        return view('admin.encadrants.edit')->with('encadrant', $encadrant);
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
        $validator = Validator::make($request->all(), [
            
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|unique:users|max:255',
            'tele' => 'required|unique:users|regex:/(06)[0-9]{8}/',
            'CIN' => 'required|unique:users|max:8',
            'image' => 'file|max:3028',

        ]);

        if($request->file('image') != null){
            $image = $request->file('image');
            if(!$this->isImage($image))
                return redirect()->back()->with('error', "The file is not an image.");
            $image = $this->saveFile($request->file('image')  ,'images/users');
            if($user->image != "default.jpg")
                $this->deleteFile($user->image, 'images/users');
            $user->image = $image;
        }

        foreach($users as $u)
        {
            if($u->id != $id)
            {
                if($u->email == $request->input('email'))
                    return redirect('admin/encadrants/'.$id.'/edit')->with('error', "The email has already been taken.");
                if($u->CIN == $request->input('CIN'))
                    return redirect('admin/encadrants/'.$id.'/edit')->with('error', "The cin has already been taken.");
                if($u->tele == $request->input('tele'))
                    return redirect('admin/encadrants/'.$id.'/edit')->with('error', "The tele has already been taken.");
            }   
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

        return redirect('admin/encadrants')->with('success', "Encadrant $user->name $user->lname est modifier");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enca_user = User::find($id);
        $encadrants = Encadrant::all();
        if($enca_user->image != null && $enca_user->image != "default.jpg")
            $this->deleteFile($enca_user->image, 'images/users');
        foreach ($encadrants as $encadrant)
        {
            if($encadrant->user_id == $id)
            {
                $encadrant->delete();
                break;
            }
        }
        $enca_user->delete();
        return redirect('admin/encadrants')->with('success', "Encadrant $enca_user->name $enca_user->lname est supprimer");
    }
}
