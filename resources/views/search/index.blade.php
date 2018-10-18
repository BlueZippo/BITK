@extends ('layouts.master')

@section('content')

{!! Form::open(['action' => 'SearchController@store', 'method' => 'POST']) !!} 

    <div class="form-group">

        {{Form::label('title', 'Title')}}
        {{Form::select('title', $options, $title, ['class' => 'form-control', 'placeholder' => 'Title'])}} 

    </div>

<div class="form-group">

    {{Form::label('content', 'Content')}}
    {{Form::select('content', $options, $content, ['class' => 'form-control', 'placeholder' => 'Content'])}}

</div>

<div class="form-group">

    {{Form::label('author', 'Author')}}
    {{Form::select('author', $options, $author, ['class' => 'form-control', 'placeholder' => 'Author'])}}

</div>


<div class="form-group">

    {{Form::label('popularity', 'Popularity')}}
    {{Form::select('popularity', $options, $popularity, ['class' => 'form-control', 'placeholder' => 'Popularity'])}}

</div>

<div class="form-group">

    {{Form::label('category', 'Category')}}
    {{Form::select('category', $options, $category, ['class' => 'form-control', 'placeholder' => 'Category'])}}

</div>


<div class="form-group">

    {{Form::label('tags', 'Tags')}}
    {{Form::select('tags', $options, $tags, ['class' => 'form-control', 'placeholder' => 'Tags'])}}

</div>

    {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

{!! Form::close() !!}

	
@endsection

