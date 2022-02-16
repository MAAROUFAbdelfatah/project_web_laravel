<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessPlan;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Article;
use App\Traits\FilesTrait;
class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use FilesTrait;
    public function __construct(){
        $this->middleware('encadrant');
    }
    public function index()
    {
        $articles = Article::all();
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bps = BusinessPlan::where('etat', 'valide')->get();        
        return view('admin.articles.create', compact('bps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = new Article();

        $validator = Validator::make($request->all(), [
            'abstract' => 'required',
            'type_pub' => 'required',
            'nombre_pages' => 'required|integer|min:1',
            'titre'  => 'required',
            'file_name' => 'required|file|max:3028',
            'businessPlan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/articles/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $bp = BusinessPlan::find($request->input('businessPlan_id'));
        if(!$bp)
            return redirect('admin/articles/create')->with('error', "The project does not exist.");
        $file_name = $request->file('file_name');
        if(!$this->isPDF($file_name))
            return redirect()->back()->with('error', "The file is not a PDF.");
        
        $file_name = $this->saveFile($request->file('file_name')  ,'documents/articles');

        $article->businessPlan_id = $request->input('businessPlan_id');
        $article->abstract = $request->input('abstract');
        $article->type_pub = $request->input('type_pub');
        $article->nombre_pages = $request->input('nombre_pages');
        $article->titre = $request->input('titre');
        $article->file_name = $file_name;
        $article->save();
        return redirect('admin/articles')->with('success', "article $article->titre est ajouter.");
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
        $bps = BusinessPlan::where('etat', 'valide')->get(); 
        $article = Article::find($id);     
        return view('admin.articles.edit', compact('bps', 'article'));
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
        $article = Article::find($id);

        $validator = Validator::make($request->all(), [
            'abstract' => 'required',
            'type_pub' => 'required',
            'nombre_pages' => 'required|integer|min:1',
            'titre'  => 'required',
            'file_name' => 'file|max:3028',
            'businessPlan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $bp = BusinessPlan::find($request->input('businessPlan_id'));
        if(!$bp)
            return redirect()->back()->with('error', "The project does not exist.");
        if($request->file('file_name') != null){
            $file_name = $request->file('file_name');
            if(!$this->isPDF($file_name))
                return redirect()->back()->with('error', "The file is not a PDF.");
            $file_name = $this->saveFile($request->file('file_name')  ,'documents/articles');
            $this->deleteFile($article->file_name, 'documents/articles');
            $article->file_name = $file_name;
        }
        $article->businessPlan_id = $request->input('businessPlan_id');
        $article->abstract = $request->input('abstract');
        $article->type_pub = $request->input('type_pub');
        $article->nombre_pages = $request->input('nombre_pages');
        $article->titre = $request->input('titre');
        $article->save();
        return redirect('admin/articles')->with('success', "article $article->titre est modifier.");
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $this->deleteFile($article->file_name, 'documents/articles');
        $article->delete();
        return redirect()->back()->with('success', "Article $article->titre est supprimer");
       
    }

    
}
