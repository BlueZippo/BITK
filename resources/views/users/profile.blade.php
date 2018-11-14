@extends('layouts.master')


@section('content')

<div class="nav-wrapper">
    @include('pages.nav')
</div>

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

<div class="profile-header" @if($user->background) style="background-image:url({{$user->background}})" @endif >

    <div class="profile-background-button">

        <a href="" data-toggle="modal" data-target="#updateProfileBackgroundModal"><i class="fa fa-camera"></i> Update Profile Background</a>

    </div>

    <div class="profile-avatar">
        @if ($user->photo)
        <img id="profile-img" src="{{$user->photo}}">
        @else
        <img id="profile-img" src="/public/no-image-available.png">
         @endif

         <div class="hover">
            <a href="" data-toggle="modal" data-target="#updateProfilePhotoModal"><i class="fa fa-camera"></i> Update Profile Picture</a>
         </div>   
    </div>
</div>

@include('users.profile-upload-photo')
@include('users.profile-upload-background')


{!! Form::model($user, ['method' => 'post','route' => ['users.profile_update']]) !!}

<div class="row">

    <div class="col-md-6">        

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

                        <strong>Instagram:</strong>

                        {!! Form::text('instagram', null, array('placeholder' => 'Instagram','class' => 'form-control')) !!}

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

        </div>

    </div>        

    <div class="col-md-6">

        

        <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">

                    <strong>Short Profile:</strong>

                    {!! Form::textarea('profile', null, array('placeholder' => 'Short Profile','class' => 'form-control')) !!}

                </div>

            </div>

        </div>

    </div>
    
</div>

<div class="row">
    
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">

        <button type="submit" class="btn btn-primary">Submit</button>

    </div>

</div>

{!! Form::close() !!}


@endsection