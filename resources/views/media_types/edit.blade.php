@extends('layouts.master')


@section('content')

<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>Edit Media Type</h2>

        </div>

        <div class="pull-right">

            <a class="btn btn-primary" href="{{ route('media_types.index') }}"> Back</a>

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


{!! Form::model($media, ['method' => 'PATCH','route' => ['media_types.update', $media->id]]) !!}

<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Name:</strong>

            {!! Form::text('media_type', null, array('placeholder' => 'Media Type','class' => 'form-control')) !!}

        </div>

         <div class="form-group">

            <strong>Icon:</strong>

            {!! Form::text('icon', null, array('placeholder' => 'Fontawesome icon','class' => 'form-control')) !!}

        </div>

    </div>  


    <div class="col-xs-12 col-sm-12 col-md-12">

        <button type="submit" class="btn btn-primary">Submit</button>

    </div>

</div>

{!! Form::close() !!}


@endsection