<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UsersnvController extends Controller
{
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
        $usersnovs = User::where('valide', NULL)->get();
        return view('admin.usersnov.index', compact('usersnovs'));
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $usersnovs = User::where('valide', NULL)
            ->where(function ($query) use ($request) {
                    $query->where('name', "like", "%" . $request->search . "%");
                    $query->orWhere('lname', "like", "%" . $request->search . "%");
                    $query->orWhere('email', "like", "%" . $request->search . "%");
                })->get();
            if($usersnovs)
            {
                foreach ($usersnovs as $key => $usersnov) {
                $output.='<tr>'.
                '<td>
                <a href="#"><i class="fas fa-mouse"></i></a>
                </td>
                <td>'.$usersnov->lname.'</td>'.
                '<td>'.$usersnov->name.'</td>'.
                '<td>'.$usersnov->email.'</td>
                <td class="project-actions text-right">
                                                <form style="display: contents;" method="post"
                                                    action="'.route('usersnvs.valide', $usersnov->id).'">

                                                    '. csrf_field().'
                                                    '. method_field('put').'
                                                    <td>
                                                    <div class="form-group col-md-">
                                                        <select name="type" id="inputState" class="form-control">
                                                        <option selected value="admin">Admin</option>
                                                        <option value="encadrant">Encadrant</option>
                                                        <option value="co-encadrant">Co-encadrant</option>
                                                        <option value="etudiant">Etudiant</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-clipboard-check"></i>
                                                        Valide
                                                    </button>
                                                </td>
                                                </form>
                                            <td>
                                                <form style="display: contents;" method="post"
                                                    action="'.route('usersnvs.destroy', $usersnov->id).'">
                                                    '. csrf_field().'
                                                    '.method_field('delete').'
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                            </td>
                
                </tr>';
                }
                return \Response($output);
            }
        }
    }

    public function valide(Request $request, $id)
    {
        $user = User::find($id);
        $user->valide = "valide";
        $user->type = $request->input('type');
        $user->save();
        return redirect()->back()->with('success', $user->name.' est valide');
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', "utilisateur $user->name $user->lname est supprimer");
    }
}
