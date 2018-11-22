@extends('layouts.master')


@section('content')

<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>Edit Domain</h2>

        </div>


        <div class="pull-right">

            <a class="btn btn-primary" href="{{ route('admin.links.parser') }}"> Back</a>

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

{!! Form::model($link, ['method' => 'PATCH','route' => ['admin.links.update', $link->id]]) !!}


<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Domain:</strong>

            {!! Form::text('domain', $link->domain, array('placeholder' => 'Enter Domain Name','class' => 'form-control')) !!}

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Title:</strong>

            {!! Form::text('title', $link->title, array('placeholder' => 'Enter the tag for the site title','class' => 'form-control')) !!}

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Description:</strong>

            {!! Form::text('description', $link->description, array('placeholder' => 'Enter the tag for the site description','class' => 'form-control')) !!}

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Image:</strong>

            {!! Form::text('image', $link->image, array('placeholder' => 'Enter the tag for the site featured image','class' => 'form-control')) !!}

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-right">

        <button type="submit" class="btn btn-primary">Submit</button>

    </div>

</div>

{!! Form::close() !!}


@endsection