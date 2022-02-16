@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Ajouter Membre</h1>
        <i class="nav-icon fas fa-users fa-lg br-5"></i><br/>
        <label>{{$equipe->nom}}</label>
    </div>
    <div class="container mg-5">
        @include('inc.messages')
        <form method="POST" action={{route('equipes.members.store')}}>
            {{ csrf_field() }}
            <div class="mb-3 col">
                <input type="hidden" name="id" value="{{$equipe->id}}">
                <label for="exampleInputEmail1" class="form-label">Email adresse pour le membre ajouter</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <button type="submit" class="btn btn-primary mt-5">Ajouter</button>
            </div>       
        </form>
    </div>
@endsection