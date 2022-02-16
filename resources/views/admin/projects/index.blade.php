@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Projects</h1>
    </div>
    
        <!-- Main content -->
        @if(count($projects) > 0)
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
                                                Theme
                                            </th>
                                            <th style="width: 30%">
                                                Description
                                            </th>
                                        </tr>
                                    </thead>
                                    
                                    @foreach($projects as $business_plan)
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="{{route('projects.show', $business_plan->id)}}"><i class="fas fa-mouse"></i></a>
                                            </td>
                                            <td>
                                                {{$business_plan->theme}}
                                            </td>
    
                                            <td>
                                                {{\Illuminate\Support\Str::limit($business_plan->description, 20, '...') }}
                                            </td>
                                            @isEncadrant
                                            <td class="text-right">
                                                <a type="submit" class="btn btn-info btn-sm"
                                                    href="{{route('projects.edit', $business_plan->id)}}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Modifier
                                                </a>
                                        
                                                <form style="display: contents;" method="post"
                                                    action={{route('projects.destroy', $business_plan->id)}}>
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
                <h3>Aucun Projet exist</h3>
            </div>
        @endif
        <!-- /.content -->
@endsection