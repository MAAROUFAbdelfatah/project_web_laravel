@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Modifier Etudiant</h1>
    </div>
    <div class="container mg-5">
        @include('inc.messages')
        <form method="POST" action="{{route('etudiants.update', $user->id)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="form-row">
                <div class="col">
                    <label for="inputLName">Prenom</label>
                    <input name="fname" type="text" class="form-control" value="{{$user->name}}">
                </div>
                <div class="col">
                    <label for="inputFName">Nom</label>
                    <input name="lname" type="text" class="form-control" value="{{$user->lname}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input name="email" type="email" class="form-control" id="inputEmail4" value="{{$user->email}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Telephone</label>
                    <input name="tele" type="text" class="form-control" id="inputPassword4" value="{{$user->tele}}">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="inputLCNE">CNE</label>
                    <input name="CNE" type="text" class="form-control" value="{{$etudiant->CNE}}">
                </div>
                <div class="col">
                    <label for="inputAppoger">Nom</label>
                    <input name="appoger" type="text" class="form-control" value="{{$etudiant->appoger}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCin">CIN</label>
                    <input name="CIN" type="text" class="form-control" id="inputCity" value="{{$user->CIN}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputState">Type</label>
                    <select name="type" id="inputState" class="form-control">
                        <option {{$user->type == 'admin'?'selected':''}} value="admin">Admin</option>
                        <option {{$user->type == 'encadrant'?'selected':''}} value="encadrant">Encadrant</option>
                        <option {{$user->type == 'co-ncadrant'?'selected':''}} value="co-ncadrant">Co-encadrant</option>
                        <option {{$user->type == 'etudiant'?'selected':''}} value="etudiant">Etudiant</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col mb-3">
                    <label for="inputPassword">Password</label>
                    <input name="password" type="password" class="form-control" id="inputPassword">
                </div>
                <div class="col mb-3">
                    <label for="formFile" class="form-label">Profile image</label>
                    <input name="image" type="file" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href ="{{route('etudiants.index')}}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection