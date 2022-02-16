@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Ajouter Busniess Plan</h1>
    </div>
    <div class="container mg-5">
        @include('inc.messages')
        <form method="POST" action={{route('busniess_plans.store')}} enctype="multipart/form-data">
            {{ csrf_field() }}
            {{-- {{ method_field('put') }} --}}
            <div class="col form-row">
                <div class="form-group col-md-6">
                    <label for="inputName">Theme</label>
                    <input name="theme" type="text" class="form-control" placeholder="theme de votre projet">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputState">Equipe</label>
                    <select name="equipe_id" id="inputState" class="form-control">
                        <option selected value="">Equipe</option>
                        @foreach ($equipes as $equipe)
                            <option value="{{$equipe->id}}">{{$equipe->nom}}</option>
                        @endforeach  
                    </select>
                </div>
            </div>
            <div class="col mb-3 mt-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="8"></textarea>
            </div>
            <div class="col mb-3">
                <label for="formFile" class="form-label">image (png, jpg, ..)</label>
                <input name="image" type="file" class="form-control">
            </div>
            <div class="col mb-3">
                <label for="formFile" class="form-label">Busniess Plan sous forme de PDF</label>
                <input name="file_name" type="file" class="form-control">
            </div> 
            <div class="col ">
                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href ="{{route('busniess_plans.index')}}" class="btn btn-secondary">Annuler</a>
            </div>        
        </form>
    </div>
@endsection