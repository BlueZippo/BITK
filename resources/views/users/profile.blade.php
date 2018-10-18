@extends('layouts.master')


@section('content')

<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>Profile</h2>

        </div>

        <div class="pull-right">

            <a class="btn btn-primary" href="{{ route('home') }}"> Back</a>

        </div>

    </div>

</div>


@if (count($errors) > 0)

  <div class="alert alert-danger">

    <strong>Whoops!</strong> There were some problems with your input.<br><br>

    <ul>

       @foreach ($errors->all() as $error)

         <li>{{ $error }}</li>

       @endforeach

    </ul>

  </div>

@endif

<form id="upload-image-form" action="/users/profile/upload" method="post" enctype="multipart/form-data">
    <div id="image-preview-div">
        <label for="exampleInputFile">Selected image:</label>
        <br>
        @if ($user->photo)
        <img id="preview-img" src="{{$user->photo}}">
        @else
        <img id="preview-img" style="display:none">
        @endif
        </div>
        <div class="form-group">
            {!! Form::file('image', array('class' => 'image', 'id' => 'file')) !!}
        </div>
    <button class="btn btn-primary" id="upload-button" type="submit" disabled>Upload image</button>
</form>

<div class="alert alert-info" id="loading" style="display: none;" role="alert">
    Uploading image...
    <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        </div>
    </div>
</div>


{!! Form::model($user, ['method' => 'post','route' => ['users.profile_update']]) !!}

<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Name:</strong>

            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Email:</strong>

            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'readonly' => 'readonly')) !!}

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Password:</strong>

            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Confirm Password:</strong>

            {!! Form::password('password_confirmation', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}

        </div>

    </div>

    
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">

        <button type="submit" class="btn btn-primary">Submit</button>

    </div>

</div>

{!! Form::close() !!}


@endsection