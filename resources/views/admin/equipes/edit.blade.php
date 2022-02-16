@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Modifier Equipe</h1>
    </div>
    <div class="container mg-5">
        @include('inc.messages')
        <form method="POST" action={{route('equipes.update', $equipe->id)}} enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="col">
                <label for="inputName">Nom d'equipe</label>
                <input value="{{$equipe->nom}}" name="nom" type="text" class="form-control" placeholder="nom d'equipe">
            </div>
            <div class="col mb-3 mt-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="5">{{$equipe->description}}</textarea>
            </div>
            <div class="col mb-3">
                <label for="formFile" class="form-label">image (png, jpg, ..)</label>
                <input name="image" type="file" class="form-control">
            </div> 
            <div class="col ">
                <button type="submit" class="btn btn-primary">Modifier</button>
                <a href ="{{route('equipes.index')}}" class="btn btn-secondary">Annuler</a>
            </div>        
        </form>
    </div>
@endsection