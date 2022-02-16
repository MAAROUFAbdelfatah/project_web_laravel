<?php

namespace App\Http\Controllers;
use App\Models\BusinessPlan;
use App\Models\Equipe;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\FilesTrait;
use Illuminate\Support\Facades\Auth; 

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use FilesTrait;
    public function __construct(){
        $this->middleware('etudiant');
    }
    public function index()
    {
       if (Auth::user()->isEncadrant()){
            $equipes = User::getEncadrant(Auth::user()->id)->equipes;
            $projects = collect();
            foreach($equipes as $equipe)
            {
               $bps = $equipe->businessPlans;
                foreach($bps as $bp)
                {
                    if ($bp->etat == "valide")
                        $projects->push($bp);
                }
            }
        }
        
        
        elseif (Auth::user()->isCoEncadrant())
        {
            $equipes = User::getCoencadrant(Auth::user()->id)->equipes;
            $projects = collect();
            foreach($equipes as $equipe)
            {
                $bps = $equipe->businessPlans;
                foreach($bps as $bp)
                {
                    if ($bp->etat == "valide")
                        $projects->push($bp);
                }
            }
        }
        elseif(Auth::user()->isEtudiant())
        {
            $equipes = collect();
            $equipes->push(User::getEtudiant(Auth::user()->id)->equipe);
            $projects = collect();
            foreach($equipes as $equipe)
            {
                $bps = $equipe->businessPlans;
                foreach($bps as $bp)
                {
                    if ($bp->etat == "valide")
                        $projects->push($bp);
                }
            }
        }
        else
            $projects = BusinessPlan::where('etat', 'valide')->get();
        return view('admin.projects.index', compact('projects'));
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
        $bp = BusinessPlan::find($id);
        $taches = $bp->taches;
        $equipe = $bp->equipe;
        $articles = $bp->articles;
        $members = User::getUsers($bp->equipe->etudiants, $bp->equipe->ecadrants);
        return view('admin.projects.show', compact('bp', 'taches', 'members', 'equipe', 'articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $equipes = Equipe::all();
        $bp = BusinessPlan::find($id);
        return view('admin.projects.edit', compact('bp', 'equipes'));
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
        $bp = BusinessPlan::find($id);

        $validator = Validator::make($request->all(), [
            'theme' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/projects/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $equipe = Equipe::find($request->input('equipe_id'));
        
        if(!$equipe)
            return redirect()->back()->with('error', "The equipe does not exist.");

        if($request->file('image') != null)
        {
            $image = $request->file('image');
            if(!$this->isImage($image))
                return redirect()->back()->with('error', "The file is not an image.");
            $image = $this->saveFile($request->file('image')  ,'images/business_plans');
            if($bp->image != "default.jpg")
                $this->deleteFile($bp->image, 'images/business_plans');
            $bp->image = $image;
        }
        
        if($request->file('file_name') != null)
        {
            $file_name = $request->file('file_name');
            if(!$this->isPDF($file_name))
                return redirect()->back()->with('error', "The file is not a PDF.");
            if($bp->file_name != null)
                $this->deleteFile($bp->file_name, 'documents/business_plans');
            $file_name = $this->saveFile($request->file('file_name')  ,'documents/business_plans');
            $bp->file_name = $file_name;
        }

        $bp->theme = $request->input('theme');
        $bp->description = $request->input('description');
        $bp->equipe_id = $equipe->id;
        $bps = BusinessPlan::where('theme',  $bp->theme)->get();

        if(count($bps) > 1)
            return redirect('admin/projects/'.$id.'/edit')->with('error', "The theme has already been taken.");

        $bp->save();
        return redirect('admin/projects')->with('success', "Project $bp->theme est modifier.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $business_plans = BusinessPlan::find($id);
        $taches = $business_plans->taches;
        foreach ($taches as $tache)
            $tache->delete();
        $articles = $business_plans->articles;
        foreach ($articles as $article)
            $article->delete();
        if($business_plans->image != null && $business_plans->image != "default.jpg")
            $this->deleteFile($business_plans->image, 'images/business_plans');
        if($business_plans->file_name != null)
            $this->deleteFile($business_plans->file_name, 'documents/business_plans');
        $business_plans->delete();
        return redirect('admin/projects')->with('success', 'Project '.$business_plans->theme.' est supprimer');
    }
}
