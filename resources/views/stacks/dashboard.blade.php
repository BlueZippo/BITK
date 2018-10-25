@extends ('layouts.master')

@section('content')

    <div class="stack-wrapper">

        <div class="row">

    		<div class="col-md-7 content">

                <h2 class="stack-title">{{$stack->title}} <span>Last updated: {{date("M d, Y", strtotime($stack->updated_at))}} <i class="fa fa-comment"></i> English <i class="fa fa-plus-circle"></i></span></h2>

                <hr />

                {!! html_entity_decode($stack->content) !!}


                <div class="meta">

                    <div class="author user-ctrl">

                        <p><span>Created By:</span></p>

                        <div class="avatar">

                            @if ($stack->user->photo)

                                <img src="{{$stack->user->photo}}">

                            @else

                                <div class="inner">

                                    {{ render_initials( $stack->user->name ? $stack->user->name : $stack->user->email   )}}

                                </div>

                            @endif


                        </div>


                        <p>{{$stack->user->name}}</p>

                    </div>


                    <div class="stack-rate">

                        <a data-id="{{$stack->id}}" class="upvote btn btn-primary">Upvote | {{$upVotes}}</a> <a data-id="{{$stack->id}}" class="downvote">Downvote</a>
                        <div class="divider"></div>
                        <a href="#" class="icon-social"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="icon-social"><i class="fa fa-instagram"></i></a>
                        <a href="#" class="icon-social"><i class="fa fa-pinterest"></i></a>

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

    @foreach($medias as $media)

        <div class="card">

            <div class="card-header">

                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#category{{$media->id}}" aria-expanded="true" aria-controls="collapseOne">
                    {{$media->media_type}}
                </button>
                <div class="divider"></div>

            </div>

            <div class="collapse" id="category{{$media->id}}" data-category="{{$media->id}}">

                <div class="container">

                    <div class="row stack-links">

                        @if (count($links))

                            @php $linkCounter = 0; @endphp

                            @foreach($links as $link)

                                @if ($link->media_id == $media->id)

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
