@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Modifier Encadrant</h1>
    </div>
    <div class="container mg-5">
        @include('inc.messages')
        <form method="POST" action="{{route('encadrants.update', $encadrant->id)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="form-row">
                <div class="col">
                    <label for="inputLName">Prenom</label>
                    <input name="fname" type="text" class="form-control" value="{{$encadrant->name}}">
                </div>
                <div class="col">
                    <label for="inputFName">Nom</label>
                    <input name="lname" type="text" class="form-control" value="{{$encadrant->lname}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input name="email" type="email" class="form-control" id="inputEmail4" value="{{$encadrant->email}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Telephone</label>
                    <input name="tele" type="text" class="form-control" id="inputPassword4" value="{{$encadrant->tele}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCin">CIN</label>
                    <input name="CIN" type="text" class="form-control" id="inputCity" value="{{$encadrant->CIN}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputState">Type</label>
                    <select name="type" id="inputState" class="form-control">
                    <option {{$encadrant->type == 'admin'?'selected':''}} value="admin">Admin</option>
                    <option {{$encadrant->type == 'encadrant'?'selected':''}} value="encadrant">Encadrant</option>
                    <option {{$encadrant->type == 'co-ncadrant'?'selected':''}} value="co-ncadrant">Co-encadrant</option>
                    <option {{$encadrant->type == 'etudiant'?'selected':''}} value="etudiant">Etudiant</option>
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
            <a href ="{{route('encadrants.index')}}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection