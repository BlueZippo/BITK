@extends ('layouts.master')

@section('content')

	<div class="row">
        
		<div class="col-md-12">

            <h2>{{$stack->title}} <small>{!! html_entity_decode($follow) !!}</small></h2>

            {!! html_entity_decode($stack->content) !!}

        </div>
        
	</div>

    <ul>

    @foreach($categories as $category)

        <li data-toggle="collapse" data-target="#category-{{$category->id}}">{{$category->cat_name}}

            <div class="row collapse" id="category-{{$category->id}}">
                @foreach($links as $link)                    
                    @if ($link->category->contains($category->id))
                        <div class="col-md-3 card card-body">
                            <div class="well">
                                <a href="{{$link->link}}" target="_blank">{{$link->title}}</a>
                            </div>    
                        </div>    
                    @endif                    
                @endforeach
            </div>

        </li>

    @endforeach

    </ul>

   

@endsection