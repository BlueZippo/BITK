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

            <h2><i class="fa fa-gift"></i> Edit What's New</h2>

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


{!! Form::open(array('route' => array('admin.whatsnew.update', $new->id),'method'=>'POST')) !!}

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Date:</strong>

                <input type="text"  name="published_date" class="form-control date" placeholder="Date" value="{{$new->published_date}}" />

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Type:</strong>

                <select name="type" class="form-control">   
                    @if ($new->type == 'whatsnew')
                    <option value="whatsnew" selected>What's New</option>
                    <option value="news">News</option>
                    @else
                    <option value="whatsnew">What's New</option>
                    <option value="news" selected>News</option>
                    @endif
                </select> 

            </div>

        </div>

    </div>    

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Title:</strong>

                {!! Form::text('title', $new->title, array('placeholder' => 'title','class' => 'form-control', 'required' => true)) !!}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Subtitle:</strong>

                {!! Form::text('subtitle', $new->subtitle, array('placeholder' => 'subtitle','class' => 'form-control')) !!}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Body:</strong>

                <br/>

                {!! Form::textarea('content', $new->content, array('placeholder' => 'Content','class' => 'form-control', 'required' => true)) !!}
               

            </div>

        </div>


        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Excerpt:</strong>

                <br/>

                {!! Form::textarea('excerpt', $new->excerpt, array('placeholder' => 'Excerpt','class' => 'form-control', 'rows' => 2)) !!}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </div>

</form>

@endsection


