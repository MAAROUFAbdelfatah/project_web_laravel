@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Modifier Tache</h1>
    </div>
    <div class="container mg-5">
        @include('inc.messages')
        <form method="POST" action="{{route('taches.update', [$tache, $bp->id])}}">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <input type="hidden" name="id" value="{{$bp->id}}">
            <div class="col form-row">
                <div class="form-group col-md-6">
                    <label for="inputName">Nom</label>
                    <input name="nom" value="{{$tache->nom}}"type="text" class="form-control" placeholder="nom de tache">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputName">delai par jour</label>
                    <input name="delai_estimer" value="{{$tache->delai_estimer}}" type="text" class="form-control" placeholder="number des jour pou terminer cette tache">
                </div>
            </div>
            <div class="col mb-3 mt-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="8">{{$tache->description}}</textarea>
            </div>
            <div class="col form-row">
                <div class="form-group col-md-6">
                    <label for="inputName">date de debut</label>
                    <input name="debut" type="date"  value = "{{$tache->debut? Carbon\Carbon::parse($tache->debut)->format('Y-m-d'): ""}}" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputName">date de fin</label>
                    <input name="fin" type="date" value = "{{$tache->fin? Carbon\Carbon::parse($tache->fin)->format('Y-m-d'): ""}}" class="form-control">
                </div>
            </div>
            <div class="col bm-5">
                <button type="submit" class="btn btn-primary">Modifier </button>
                {{-- <a href ="{{route('busniess_plans.show', $bp->id)}}" class="btn btn-secondary">Annuler</a> --}}
            </div>        
        </form>
    </div>
@endsection