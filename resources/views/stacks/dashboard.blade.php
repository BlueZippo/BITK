@extends ('layouts.master')

@section('content')

    <div class="stack-wrapper">

        <div class="row">

    		<div class="col-md-7 content">

                <h2>{{$stack->title}}</h2>

                <hr />

                {!! html_entity_decode($stack->content) !!}


                <div class="meta">

                    <div class="author user-ctrl">


                        Created by:

                        <div class="avatar">

                            @if ($stack->user->photo)

                                <img src="{{$stack->user->photo}}">

                            @else

                                <div class="inner">

                                    {{ render_initials( $stack->user->name ? $stack->user->name : $stack->user->email   )}}

                                </div>

                            @endif


                        </div>


                        {{$stack->user->name}}


                    </div>


                    <div class="stack-rate">


                        <a data-id="{{$stack->id}}" class="upvote btn btn-primary">Upvote | {{$upVotes}}</a> <a data-id="{{$stack->id}}" class="downvote">Downvote</a>

                        <a class=""><i class="fa fa-facebook"></i></a>
                        <a class=""><i class="fa fa-instagram"></i></a>
                        <a class=""><i class="fa fa-pinterest"></i></a>


                    </div>


                </div>

            </div>

            <div class="col-md-5">

                @if ($stack->video_id)

                    @include('stacks.dashboard-youtube')

                @else

                   <div class="featured-image">

                        <img src="/images/youtube-image.png">

                    </div>


                @endif



            </div>

    	</div>

    </div>

   <div class="accordion stack-single">

    @foreach($categories as $category)

        <div class="card">

            <div class="card-header">

                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#category{{$category->id}}" aria-expanded="true" aria-controls="collapseOne">
                    {{$category->cat_name}}
                </button>

            </div>

            <div class="collapse" id="category{{$category->id}}" data-category="{{$category->id}}">

                <div class="container">

                    <div class="row stack-links">

                        @if (count($links))

                            @php $linkCounter = 0; @endphp

                            @foreach($links as $link)

                                @if ($link->category->contains($category->id))

                                     <div class="col-md-3" id="link{{$linkCounter}}">
                                        @include('links.box')
                                    </div>

                                    @php $linkCounter++ @endphp

                                @endif


                            @endforeach

                        @endif


                    </div>


                </div>

            </div>


        </div>


    @endforeach

    </div>

    <br /><br />

    @include('stacks.related')



@endsection
