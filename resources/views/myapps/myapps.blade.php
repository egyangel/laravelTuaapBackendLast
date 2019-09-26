@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <a href="{{ url ('/myapp/create')}}" class="btn btn-success"> Create new </a>




            @include('errors.error')

            @if ($myapps->count() > 0)

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>id ntification</th> 
                    <th>logo</th>
                    <th>splash</th>
                    <th>Edit</th>
                    <th>DELETE</th>
                </tr>
                </thead>
                
                <tbody>
                @foreach ($myapps as $index=>$myapp)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $myapp->appname }}</td> 
                        <td>{{ $myapp->appidentificationkey }}</td> 
                        <td><img src="{{ $myapp->logo_path }}" style="width: 100px;" class="img-thumbnail" alt=""></td>
                        <td><img src="{{ $myapp->splash_path }}" style="width: 100px;" class="img-thumbnail" alt=""></td>
                        <td><a href="myapp/{{ $myapp->id }}/edit" class="btn btn-info"><i class="fa fa-edit">edit</i></a></td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'url' => ['myapp', $myapp->id]]) !!}
                                <div class="form-group">
                                    <div class=" ">
                                        <button type="submit" class="btn  btn-danger">
                                            <i class="fa fa-trash">DELETE</i>  
                                        </button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                
                @endforeach
                </tbody>

            </table><!-- end of table -->






            @endif



            
        </div>
    </div>
</div>
@endsection
