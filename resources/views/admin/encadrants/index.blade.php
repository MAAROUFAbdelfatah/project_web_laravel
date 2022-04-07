@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Encadrants</h1>
    </div>

    <div class="container">
        <div class="search">
            {{ csrf_field() }}
            <input type="search" name="search" id="search" placeholder="Chercher" class = "form-control col-md-6 mb-5"/>
        </div>
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
                                    
                                    
                                    <tbody class="alldata">
                                        @foreach($encadrants as $encadrant)
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
                                       
                        
                                        @endforeach 
                                    </tbody>
                                    
                                    <tbody id="Content" class="searchdata">
                                    </tbody>
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

        {{-- javascript --}}
        <script type="text/javascript">
            $('#search').on('keyup',function(){
            $value=$(this).val();

            if($value)
            {
                $('.alldata').hide();
                $('.searchdata').show();
            }else{
                $('.alldata').show();
                $('.searchdata').hide();
            }
            $.ajax({
            type : 'get',
            url : '{{route("encadrants.search")}}',
            data:{'search':$value},
            success:function(data){
                $('#Content').html(data);
            }
            });
            })
            </script>
        <script type="text/javascript">
            $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
            </script>
        
@endsection