@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Ajouter Article</h1>
    </div>
    <div class="container mg-5">
        @include('inc.messages')
        <form method="POST"  action={{route('articles.update', $article->id)}} enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="col form-row">
                <div class="form-group col-md-6">
                    <label >Titre</label>
                    <input name="titre" type="text" class="form-control" placeholder="titre de votre projet" value="{{$article->titre}}"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputName">nombre des pages</label>
                    <input name="nombre_pages" type="text" class="form-control" placeholder="nombre des pages" value="{{$article->nombre_pages}}">
                </div>
            </div>
            <div class="col form-row">
                <div class="form-group col-md-6">
                    <label for="inputState">Projet</label>
                    <select name="businessPlan_id" id="inputState" class="form-control">
                        @foreach ($bps as $bp)
                            <option {{ $bp->id == $article->businessPlan_id?'selected':''}} value="{{$bp->id}}">{{$bp->theme}}</option>
                        @endforeach  
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputState">Publication</label>
                    <select name="type_pub" id="inputState" class="form-control">
                        <option {{$article->type_pub == 'conference'?'selected':''}} value="conference">conference</option>
                        <option {{$article->type_pub == 'journal'?'selected':''}} value="journal">journal</option>
                    </select>
                </div>
            </div>
            <div class="col mb-3 mt-3">
                <label for="exampleFormControlTextarea1" class="form-label">Abstract</label>
                <textarea name="abstract" class="form-control" id="exampleFormControlTextarea1" rows="8">{{$article->abstract}}</textarea>
            </div>
            <div class="col mb-3">
                <label for="formFile" class="form-label">Article sous forme de PDF</label>
                <input name="file_name" type="file" class="form-control">
            </div> 
            <div class="col mb-5">
                <button type="submit" class="btn btn-primary">Modifier</button>
                <a href ="{{route('articles.index')}}" class="btn btn-secondary">Annuler</a>
            </div> 
                 
        </form>
    </div>
@endsection