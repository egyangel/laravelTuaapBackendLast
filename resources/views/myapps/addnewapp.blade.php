@extends('layouts.app')

 

 
@section('content')
<!-- Content Header (Page header) --> 
<div class="container"> 
    <div class="row">
      <div class="col-12"> 
          <div class="box-header text-center">
            <h3 class="box-title">Add New App</h3>
          </div>
          <!-- /.box-header --> 
 
              @include('errors.error')

              {!! Form::open(['url' => '/myapp', 'class' => 'form-group' , 'files' => true]) !!}

                          <div class="form-group{{ $errors->has('appname') ? ' has-error' : '' }}">
                              <label for="appname" class=" control-label"> App Name</label>
                              <div class=" ">
                                  <input id="appname" type="text" class="form-control" name="appname" value="{{ old('appname') }}" required autofocus>

                                  @if ($errors->has('appname'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('appname') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>    

                          <div class="form-group">
                              {!! Form::label('Logo App') !!}
                              {!! Form::file('logoapp', ['class' => 'form-control']) !!}
                          </div>

                          <div class="form-group">
                              {!! Form::label('Splash Screen') !!}
                              {!! Form::file('splash', ['class' => 'form-control']) !!}
                          </div>
  

  

                          <div class="form-group">
                              {!! Form::submit('Add New App', ['class' => 'form-control btn btn-block btn-success']) !!}
                          </div>
                  {!! Form::close() !!}
      
    </div> 
  </div> 
</div>

@endsection
