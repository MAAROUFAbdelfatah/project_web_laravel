@extends('layouts.master')

@section('content')

    <div class="jumbotron text-center">
        <h1>Business Plans</h1>
    </div>
    
        <!-- Main content -->
        @if(count($business_plans) > 0)
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
                                                Theme
                                            </th>
                                            <th style="width: 30%">
                                                Description
                                            </th>
                                            
                                            <th style="width: 5%">
                                                PDF
                                            </th>     
                                        </tr>
                                    </thead>
                                    
                                    @foreach($business_plans as $business_plan)
                                    <tbody>
                                        <tr>
                                            <td >
                                                <a href="{{route('busniess_plans.show', $business_plan->id)}}"><i class="fas fa-mouse"></i></a>
                                            </td>
                                            <td>
                                                {{$business_plan->theme}}
                                            </td>
    
                                            <td>
                                                {{\Illuminate\Support\Str::limit($business_plan->description, 20, '...') }}
                                            </td>
                                            @if($business_plan->file_name)
                                            <td>
                                                <a href="http://127.0.0.1:8000/documents/business_plans/{{$business_plan->file_name}}" formtarget="_blank" target="_blank"><i class="fas fa-eye"></i></a>
                                            </td>
                                            @else
                                             <td></td>
                                            @endif
                                            <td class="text-right">
                                                @isAdmin
                                                <form style="display: contents;" method="post"
                                                    action={{route('busniess_plans.valide', $business_plan->id)}}>
                                                    {{ csrf_field() }}
                                                    {{ method_field('put') }}
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-clipboard-check"></i>
                                                        Valide
                                                    </button>
                                                </form>
                                                @endisAdmin
                                                <a type="submit" class="btn btn-info btn-sm"
                                                    href="{{route('busniess_plans.edit', $business_plan->id)}}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Modifier
                                                </a>
                                        
                                                <form style="display: contents;" method="post"
                                                    action={{route('busniess_plans.destroy', $business_plan->id)}}>
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
                <h3>Aucun Business Plan exist</h3>
            </div>
        @endif
        <!-- /.content -->
@endsection