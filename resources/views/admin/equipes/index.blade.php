@extends('layouts.master')
@php
        $enca = false;
@endphp
@section('content')
    <div class="jumbotron text-center">
        <h1>Equipes</h1>
    </div>
    
        <!-- Main content -->
        @if(count($equipes) > 0)
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
                                            <th style="width: 30%">
                                                Nom d'equipe
                                            </th>

                                            <th style="width: 30%">
                                                Description
                                            </th>
                                        </tr>
                                    </thead>
                                    
                                    @foreach($equipes as $equipe)
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="{{route('equipes.show', $equipe->id)}}"><i class="fas fa-mouse"></i></a>
                                            </td>
                                            <td>
                                                {{$equipe->nom}}
                                            </td>
    
                                            <td>
                                                {{\Illuminate\Support\Str::limit($equipe->description, 20, '...') }}
                                            </td>
                                            
                                            
                                           @isEncadrant
                                            <td class="text-right">
                                                <a type="submit" class="btn btn-info btn-sm"
                                                    href="{{route('equipes.edit', $equipe->id)}}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Modifier
                                                </a>
                                        
                                                <form style="display: contents;" method="post"
                                                    action={{route('equipes.destroy', $equipe->id)}}>
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
                <h3>Aucun Equipe exist</h3>
            </div>
        @endif
        <!-- /.content -->
@endsection