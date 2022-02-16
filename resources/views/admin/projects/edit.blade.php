@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Modifier Project</h1>
    </div>
    <div class="container mg-5">
        @include('inc.messages')
        <form method="POST" action={{route('projects.update', $bp->id)}}>
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="col form-row">
                <div class="form-group col-md-6">
                    <label for="inputName">Theme</label>
                    <input value="{{$bp->theme}}" name="theme" type="text" class="form-control" placeholder="theme de votre projet">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputState">Equipe</label>
                    <select name="equipe_id" id="inputState" class="form-control">
                        <option selected value="">Equipe</option>
                        @foreach ($equipes as $equipe)
                        <option {{ $bp->equipe_id == $equipe->id? 'selected' : '' }} value="{{ $equipe->id }}"> {{ $equipe->nom }} </option>
                        @endforeach  
                    </select>
                </div>
            </div>
            <div class="col mb-3 mt-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="5">{{$bp->description}}</textarea>
            </div>
            <div class="col ">
                <button type="submit" class="btn btn-primary">Modifier</button>
                <a href ="{{route('projects.index')}}" class="btn btn-secondary">Annuler</a>
            </div>        
        </form>
    </div>
@endsection