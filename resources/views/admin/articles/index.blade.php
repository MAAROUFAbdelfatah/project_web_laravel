@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Articles</h1>
    </div>
    
        <!-- Main content -->
        @if(count($articles) > 0)
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
                                                Titre
                                            </th>
                                            <th style="width: 20%">
                                                Abstract
                                            </th>
                                            <th style="width: 20%">
                                                Project
                                            </th>
                                            <th style="width: 15%">
                                                Equipe
                                            </th>
                                        </tr>
                                    </thead>
                                    
                                    @foreach($articles as $article)
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="http://127.0.0.1:8000/documents/articles/{{$article->file_name}}" formtarget="_blank" target="_blank"><i class="fas fa-eye"></i></a>
                                            </td>
                                            <td>
                                                {{$article->titre}}
                                            </td>
    
                                            <td>
                                                {{\Illuminate\Support\Str::limit($article->abstract, 20, '...') }}
                                            </td>
                                            <td>
                                                {{$article->businessPlan->theme}}
                                            </td>
                                            <td>
                                                {{$article->businessPlan->equipe->nom}}
                                            </td>
                                            <td class="text-right">
                
                                                <a type="submit" class="btn btn-info btn-sm"
                                                    href="{{route('articles.edit', $article->id)}}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Modifier
                                                </a>
                                        
                                                <form style="display: contents;" method="post"
                                                    action={{route('articles.destroy', $article->id)}}>
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
        @include('inc.messages')
            <div class="text-center">
                <h3>Aucun Article exist</h3>
            </div>
        @endif
        <!-- /.content -->
@endsection