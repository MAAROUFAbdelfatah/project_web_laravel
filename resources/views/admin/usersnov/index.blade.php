@extends('layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1>Utilisateurs non valide</h1>
    </div>
    <div class="container">
        <div class="search">
            {{ csrf_field() }}
            <input type="search" name="search" id="search" placeholder="Chercher" class = "form-control col-md-6 mb-5"/>
        </div>
    </div>
        <!-- Main content -->
        @if(count($usersnovs) > 0)
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
                                            <th style="width: 10%">
                                                Nom
                                            </th>
                                            <th style="width: 10%">
                                                Prenom
                                            </th>
                                            <th>
                                                Email
                                            </th>
                                        </tr>
                                    </thead>
                                    
                                    
                                    <tbody class="alldata">
                                        @foreach($usersnovs as $usersnov)
                                        <tr>
                                            <td>
                                                <a href="#"><i class="fas fa-mouse"></i></a>
                                            </td>
                                            <td>
                                                {{$usersnov->lname}}
                                            </td>
    
                                            <td>
                                                {{$usersnov->name}}
                                            </td>
                                            <td class="project_progress">
                                                {{$usersnov->email}}
                                            </td>
                                            <td class="project-actions text-right">
                                                <form style="display: contents;" method="post"
                                                    action={{route('usersnvs.valide', $usersnov->id)}}>

                                                    {{ csrf_field() }}
                                                    {{ method_field('put') }}
                                                    <td>
                                                    <div class="form-group col-md-">
                                                        <select name="type" id="inputState" class="form-control">
                                                        <option selected value="admin">Admin</option>
                                                        <option value="encadrant">Encadrant</option>
                                                        <option value="co-encadrant">Co-encadrant</option>
                                                        <option value="etudiant">Etudiant</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-clipboard-check"></i>
                                                        Valide
                                                    </button>
                                                </td>
                                                </form>
                                            <td>
                                                <form style="display: contents;" method="post"
                                                    action={{route('usersnvs.destroy', $usersnov->id)}}>
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </td>
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
                <h3>Aucun utilisateur non valide exist</h3>
            </div>
        @endif
        <!-- /.content -->

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
            url : '{{route("usersnvs.search")}}',
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