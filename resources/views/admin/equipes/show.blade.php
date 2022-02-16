@extends('layouts.master')

@section('content')
    <div class="col card mb-3">
        {{-- <img src="..." class="card-img-top" alt="..."> --}}
        <div class="card-body">
                <h3 class="card-title">{{$equipe->nom}}</h3>
          <p class="card-text">{{$equipe->description}}</p>
        </div>
    </div>
    <div class="container col">
        <label>Les Membres </label>
        @isEncadrant
        <div class="text-center mb-3">
            {{-- <button type="button" class="btn btn-primary"><i class="fas fa-user-plus nav-icon mr-2"></i>Ajouter Member</button> --}}
            <a href="{{route('equipes.members.create', $equipe->id)}}" class="btn btn-primary">
                <i class="fas fa-user-plus mr-2"></i>
                <p>Ajouter Member</p>
              </a>
        </div>
        @endisEncadrant
        @if(count($members) > 0)
        <div class="content">
            @include('inc.messages')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0" style="display: block;">
                                
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%">
                                                #
                                            </th>
                                            <th style="width: 20%">
                                                Nom
                                            </th>
                                            <th style="width: 20%">
                                                Prenom
                                            </th>
                                            <th style="width: 20%">
                                                Email
                                            </th>
                                            <th style="width: 20%">
                                                Role
                                            </th>
                                        </tr>
                                    </thead>
                                    @foreach($members as $member)
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="#"><i class="fas fa-mouse"></i></a>
                                            </td>
                                            <td>
                                                {{$member->lname}}
                                            </td>
    
                                            <td>
                                                {{$member->name}}
                                            </td>
                                            <td>
                                                {{$member->email}}
                                            </td>
                                            <td>
                                                {{$member->type}}
                                            </td>
                                            @isEncadrant
                                            <td class="project-actions text-right">
                                                <form style="display: contents;" method="post"
                                                    action={{route('equipes.members.destroy', [$equipe->id, $member->id])}}>
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Supprimer
                                                    </button>
                                                </form>
                                                
                                            </td>
                                            @endisEncadrant
                                        </tr>
                                       
                        
    
                                    </tbody>
                                    @endforeach
                                     
                                    
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
    
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        @else
        @include('inc.messages')
            <div class="text-center">
                <h3>Aucun membre exist</h3>
            </div>
        @endif
    </div>
        
    
@endsection