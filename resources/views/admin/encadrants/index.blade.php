@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Encadrants</h1>
    </div>
    
        <!-- Main content -->
        @if(count($encadrants) > 0)
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
                                            <th style="width: 30%">
                                                Prenom
                                            </th>
                                            <th>
                                                Email
                                            </th>
    
                                            <th style="width: 30%">
                                            </th>
                                        </tr>
                                    </thead>
                                    
                                    @foreach($encadrants as $encadrant)
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="#"><i class="fas fa-mouse"></i></a>
                                            </td>
                                            <td>
                                                {{$encadrant->lname}}
                                            </td>
    
                                            <td>
                                                {{$encadrant->name}}
                                            </td>
                                            <td class="project_progress">
                                                {{$encadrant->email}}
                                            </td>
                                            <td class="project-actions text-right">
                                                <a type="submit" class="btn btn-info btn-sm"
                                                    href="{{route('encadrants.edit', $encadrant->id)}}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Modifier
                                                </a>
                                        
                                                <form style="display: contents;" method="post"
                                                    action={{route('encadrants.destroy', $encadrant->id)}}>
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Supprimer
                                                    </button>
                                                </form>
    
                                            </td>
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
            <div class="text-center">
                <h3>Aucun encadrant exist</h3>
            </div>
        @endif
        <!-- /.content -->
@endsection