@extends('layouts.master')

@section('scripts')

<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">

<script>
$('input.date').datepicker();
</script>

@endsection

@section('content')

<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2><i class="fa fa-gift"></i> Add What's New</h2>

        </div>

        <div class="pull-right">

            <a class="btn btn-primary" href="/admin/whatsnew"> Back</a>

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


{!! Form::open(array('route' => 'admin.whatsnew.submit','method'=>'POST')) !!}

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Date:</strong>

                <input type="text"  name="published_date" class="form-control date" placeholder="Date" value="{{$date}}" />

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Type:</strong>

                <select name="type" class="form-control">   
                    <option value="whatsnew">What's New</option>
                    <option value="news">News</option>
                </select> 

            </div>

        </div>

    </div>    

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Title:</strong>

                {!! Form::text('title', null, array('placeholder' => 'title','class' => 'form-control', 'required' => true)) !!}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Subtitle:</strong>

                <input type="text"  name="subtitle" class="form-control" placeholder="Subtitle" />

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Body:</strong>

                <br/>

                {!! Form::textarea('content', null, array('placeholder' => 'Content','class' => 'form-control', 'required' => true)) !!}
               

            </div>

        </div>


        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Excerpt:</strong>

                <br/>

                <textarea  class="form-control textarea" name="excerpt" placeholder="Excerpt"></textarea>               

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </div>

</form>

@endsection


