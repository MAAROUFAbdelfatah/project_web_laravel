<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessPlan;
use App\Models\Tache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
class TachesController extends Controller
{
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $bp = BusinessPlan::find($id);
        return view('admin.taches.create', compact('bp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tache = new Tache();
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'delai_estimer' => 'required|integer|min:1',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back() //redirect('admin/busniess_plans/'.$request->input('id').'/taches/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $tache->nom = $request->input('nom');
        $tache->description = $request->input('description');
        $tache->delai_estimer = $request->input('delai_estimer');
        $tache->businessPlan_id = $request->input('id');
        $tache->debut = $request->input('debut');
        $tache->fin = $request->input('fin');
        if(!$tache->debut)
            $tache->etat = "PAUSE";
        elseif($tache->debut && !$tache->fin)
            $tache->etat = "AU COURS";
        elseif($tache->fin)
        {
            $tache->etat = "TERMINÉ";
            $debut=Carbon::parse($tache->debut);
            $fin=Carbon::parse($tache->fin);
            $tache->delai_real = $debut->diffInDays($fin);
        }
            
        
       
        $tache->save();
        return redirect()->back()->with('success', 'tache est ajouter');//redirect('admin/busniess_plans/'.$request->input('id').'/taches/create')

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
    public function edit($id, $tache_id)
    {
        $tache = Tache::find($tache_id);
        $bp = $tache->businessPlan;
        return view('admin.taches.edit', compact('tache', 'bp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $bp_id)
    {
        $tache = Tache::find($id);
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'delai_estimer' => 'required||integer|min:1',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back() //redirect('admin/busniess_plans/'.$request->input('id').'/taches/'.$tache->id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $tache->nom = $request->input('nom');
        $tache->description = $request->input('description');
        $tache->delai_estimer = $request->input('delai_estimer');
        $tache->save();
        $tache->debut = $request->input('debut');
        $tache->fin = $request->input('fin');
        if(!$tache->debut)
            $tache->etat = "PAUSE";
        elseif($tache->debut && !$tache->fin)
            $tache->etat = "AU COURS";
        elseif($tache->fin)
        {
            $tache->etat = "TERMINÉ";
            $debut=Carbon::parse($tache->debut);
            $fin=Carbon::parse($tache->fin);
            $tache->delai_real = $debut->diffInDays($fin);
        }
        return redirect()->back()->with('success', 'tache est modifier');//redirect('admin/busniess_plans/'.$request->input('id').'/taches/'.$tache->id.'/edit')->with('success', 'tache est modifier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bp_id, $id)
    {
        $tache = Tache::find($id);
        $tache->delete();
        return redirect()->back()->with('success', "Tache $tache->name est supprimer");//redirect('admin/busniess_plans/'.$bp_id)->with('success', "Tache $tache->name est supprimer");
    }
}
