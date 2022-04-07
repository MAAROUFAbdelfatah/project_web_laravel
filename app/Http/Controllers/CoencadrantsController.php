<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Encadrant;
use Illuminate\Support\Facades\Hash;
use App\Traits\FilesTrait;
class CoencadrantsController extends Controller
{
    
    use FilesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('admin');;
    }
    public function index()
    {
        $coencadrants = User::where('type', 'co-encadrant')->get();
        return view('admin.coencadrants.index', compact('coencadrants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coencadrants.create');
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
            'image' => 'file|max:3028',

        ]);

        if ($validator->fails()) {
            return redirect('admin/coencadrants/create')
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
        $user->valide = "valide";
        $user->save();
        $user1 = User::where('email', $user->email)->get(); 
        $coencadrant = new Encadrant();
        $coencadrant->type = "nohabilite";
        $coencadrant->user_id = $user1[0]->id;
        $coencadrant->save();
        return redirect('admin/coencadrants/create')->with('success', 'Co-ncadrant est ajouter');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $coencadrants = User::where('type', 'co-encadrant')
            ->where(function ($query) use ($request) {
                    $query->where('name', "like", "%" . $request->search . "%");
                    $query->orWhere('lname', "like", "%" . $request->search . "%");
                    $query->orWhere('email', "like", "%" . $request->search . "%");
                })->get();
            if($coencadrants)
            {
                foreach ($coencadrants as $key => $coencadrant) {
                $output.='<tr>'.
                '<td>
                <a href="#"><i class="fas fa-mouse"></i></a>
                </td>
                <td>'.$coencadrant->lname.'</td>'.
                '<td>'.$coencadrant->name.'</td>'.
                '<td>'.$coencadrant->email.'</td>
                <td class="project-actions text-right">
                <a type="submit" class="btn btn-info btn-sm"
                    href="'.route('coencadrants.edit', $coencadrant->id).'">
                    <i class="fas fa-pencil-alt">
                    </i>
                    Modifier
                </a> <form style="display: contents;" method="post"
                action='.route('coencadrants.destroy', $coencadrant->id).'>
                '.csrf_field() .'
                '. method_field("delete").'
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash">
                    </i>
                    Supprimer
                </button>
            </form>

        </td>
                </tr>';
                }
                return \Response($output);
            }
        }
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
        $coencadrant = User::find($id);
        return view('admin.coencadrants.edit')->with('coencadrant', $coencadrant);
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
            'CIN' => 'required|unique:users|max:255',
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
                    return redirect('admin/coencadrants/'.$id.'/edit')->with('error', "The email has already been taken.");
                if($u->CIN == $request->input('CIN'))
                    return redirect('admin/coencadrants/'.$id.'/edit')->with('error', "The cin has already been taken.");
                if($u->tele == $request->input('tele'))
                    return redirect('admin/coencadrants/'.$id.'/edit')->with('error', "The tele has already been taken.");
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

        return redirect('admin/coencadrants')->with('success', "co-encadrant $user->name $user->lname est modifier");
        
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
        return redirect('admin/coencadrants')->with('success', "Co-encadrant $enca_user->name $enca_user->lname est supprimer");
    }
}
