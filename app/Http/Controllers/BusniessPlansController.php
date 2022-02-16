<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessPlan;
use App\Models\Equipe;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Traits\FilesTrait;
use Illuminate\Support\Facades\Auth;  
class BusniessPlansController extends Controller
{
    use FilesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('encadrant');
    }
    public function index()
    {
        if (Auth::user()->isEncadrant()){
            $equipes = User::getEncadrant(Auth::user()->id)->equipes;
            $business_plans = collect();
            foreach($equipes as $equipe)
            {
               $bps = $equipe->businessPlans;
                foreach($bps as $bp)
                {
                    if ($bp->etat == "novalide")
                        $business_plans->push($bp);
                }
            }
        }
        
        
        elseif (Auth::user()->isCoEncadrant())
        {
            $equipes = User::getCoencadrant(Auth::user()->id)->equipes;
            $business_plans = collect();
            foreach($equipes as $equipe)
            {
                $bps = $equipe->businessPlans;
                foreach($bps as $bp)
                {
                    if ($bp->etat == "novalide")
                        $business_plans->push($bp);
                }
            }
        }
        elseif(Auth::user()->isEtudiant())
        {
            $equipes = User::getEtudiant(Auth::user()->id)->equipes;
            $business_plans = collect();
            foreach($equipes as $equipe)
            {
                $bps = $equipe->businessPlans;
                foreach($bps as $bp)
                {
                    if ($bp->etat == "novalide")
                        $business_plans->push($bp);
                }
            }
        }
   
        else
            $business_plans = BusinessPlan::where('etat', 'novalide')->get();
        return view('admin.busniess_plans.index', compact('business_plans'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $equipes = Equipe::all();
        return view('admin.busniess_plans.create', compact('equipes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $busniess_plan = new BusinessPlan();

        $validator = Validator::make($request->all(), [
            'theme' => 'required|unique:business_plans',
            'description' => 'required',
            'image' => 'file|max:3028',
            'file_name'=>'file|max:5028'
        ]);

        if ($validator->fails()) {
            return redirect('admin/busniess_plans/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $equipe = Equipe::find($request->input('equipe_id'));
        if(!$equipe)
            return redirect('admin/busniess_plans/create')->with('error', "The equipe does not exist.");

        if($request->file('image') != null){
            $image = $request->file('image');
            if(!$this->isImage($image))
                return redirect()->back()->with('error', "The file is not an image.");
            $image = $this->saveFile($request->file('image')  ,'images/business_plans');
            $busniess_plan->image = $image;
        }
        else
            $busniess_plan->image = "default.jpg";

        if($request->file('file_name') != null){
            $file_name = $request->file('file_name');
            if(!$this->isPDF($file_name))
                return redirect()->back()->with('error', "The file is not a PDF.");
            $file_name = $this->saveFile($request->file('file_name')  ,'documents/business_plans');
            $busniess_plan->file_name = $file_name;
        }
        $busniess_plan->equipe_id = $request->input('equipe_id');
        $busniess_plan->theme = $request->input('theme');
        $busniess_plan->description = $request->input('description');
        $busniess_plan->etat = "novalide";
        $busniess_plan->save();
        return redirect('admin/busniess_plans/create')->with('success', 'Busniess plan est ajouter');
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
        $members = User::getUsers($bp->equipe->etudiants, $bp->equipe->ecadrants);
        return view('admin.busniess_plans.show', compact('bp', 'taches', 'equipe', 'members'));
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
        return view('admin.busniess_plans.edit', compact('bp', 'equipes'));
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
            'image' => 'file|max:3028',
            'file_name'=>'file|max:5028'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $equipe = Equipe::find($request->input('equipe_id'));
        if(!$equipe)
            return redirect()->back()->with('error', "The equipe does not exist.");

        if($request->file('image') != null){
            $image = $request->file('image');
            if(!$this->isImage($image))
                return redirect()->back()->with('error', "The file is not an image.");
            $image = $this->saveFile($request->file('image')  ,'images/business_plans');
            if($bp->image != "default.jpg")
                $this->deleteFile($bp->image, 'images/business_plans');
            $bp->image = $image;
        }
        
        if($request->file('file_name') != null){
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
        $bp->equipe_id =  $equipe->id;

        $bps = BusinessPlan::where('theme',  $bp->theme)->get();

        if(count($bps) > 1)
            return redirect('admin/busniess_plans/'.$id.'/edit')->with('error', "The theme has already been taken.");

        $bp->save();
        return redirect('admin/busniess_plans')->with('success', "Busniess plans $bp->nom est modifier.");
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
        $articles_deleter = new ArticlesController();
        $taches = $business_plans->taches;
        foreach ($taches as $tache)
            $tache->delete();
        $articles = $business_plans->articles;
        foreach ($articles as $article)
            $articles_deleter->destroy($article->id);
        if($business_plans->image != null && $business_plans->image != "default.jpg")
            $this->deleteFile($business_plans->image, 'images/business_plans');
        if($business_plans->file_name != null)
            $this->deleteFile($business_plans->file_name, 'documents/business_plans');
        $business_plans->delete();
        return redirect('admin/busniess_plans')->with('success', 'Busniess plan est supprimer');
    }

    // valide to vlidate a busniess plan to became a project.
    public function valide($id)
    {
        $bp = BusinessPlan::find($id);
        $bp->etat = "valide";
        $bp->save();
        return redirect('admin/busniess_plans')->with('success', 'Busniess plan '.$bp->theme.' est valide');
    }  
}
