@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Ajouter Coencadrant</h1>
    </div>
    <div class="container mg-5">
        @include('inc.messages')
        <form method="POST" action={{route('coencadrants.store')}} enctype="multipart/form-data">
            {{ csrf_field() }}
            {{-- {{ method_field('put') }} --}}
            <div class="form-row">
                <div class="col">
                    <label for="inputLName">Prenom</label>
                    <input name="fname" type="text" class="form-control" placeholder="prenom">
                </div>
                <div class="col">
                    <label for="inputFName">Nom</label>
                    <input name="lname" type="text" class="form-control" placeholder="nom">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input name="email" type="email" class="form-control" id="inputEmail4" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Telephone</label>
                    <input name="tele" type="text" class="form-control" id="inputPassword4" placeholder="telephone">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCin">CIN</label>
                    <input name="CIN" type="text" class="form-control" id="inputCity" placeholder="CIN">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputState">State</label>
                    <select name="type" id="inputState" class="form-control">
                    <option selected value="admin">Admin</option>
                    <option value="encadrant">Encadrant</option>
                    <option value="co-encadrant">Co-encadrant</option>
                    <option value="etudiant">Etudiant</option>
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
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href ="{{route('coencadrants.index')}}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection