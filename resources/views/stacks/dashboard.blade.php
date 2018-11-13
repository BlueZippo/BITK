@extends ('layouts.master')

@section('style')

<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link href="{{ asset('css/stack-dashboard.css') }}" rel="stylesheet">

@endsection

@section('sidebar')

<div class="stack-sidebar">

    <a class="chats" data-id="{{$stack->id}}"><i class="fa fa-comments"></i></a>

    <a class="views"><i class="fa fa-bars"></i> Change View</a>

    @if (auth::check() && auth::user()->id == $stack->user_id)

    <a class="edit" href="/stacks/{{$stack->id}}/edit"><i class="fa fa-edit"></i> Edit Stack</a>

    @endif

</div>

@endsection

@section('content')

    <div class="dashboard">
        <div class="nav-wrapper">
            @include('pages.nav')
        </div>
    </div>


    <div class="stack-wrapper">

        <div class="row">

    		<div class="col-md-7 content">

                <h2 class="stack-title">{{$stack->title}}</h2>
                <div class="stack-meta">
                    <div class="meta-topics">
                        <p><strong>Under Topic:</strong> <span>Business, Customer Experience, Strategy</span></p>
                    </div>
                    <div class="meta-date-comments">
                        <div class="date"><p>Updated: {{date("M d, Y", strtotime($stack->updated_at))}}</p></div>
                        <div class="comments"><p><i class="fas fa-comment-dots"></i> 0 Comments</p></div>
                    </div>
                </div>

                <hr />

                {!! html_entity_decode($stack->content) !!}


                <div class="meta row">

                    <div class="author user-ctrl col-md-6">

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


                    <div class="stack-rate col-md-6">

                        <div class="likes">

                            <a class="upvote" data-id="{{$stack->id}}"><i class="fas fa-thumbs-up"></i> {{$upvote}}</a>

                            <a class="downvote" data-id="{{$stack->id}}"><i class="fas fa-thumbs-down"></i></a>

                        </div>

                        <div class="social">

                            <a href="#"><i class="fab fa-facebook-square"></i></a>

            				<a href="#"><i class="fab fa-twitter"></i></a>

            				<a href="#"><i class="fab fa-linkedin"></i></a>

            				<a href="#"><i class="fab fa-instagram"></i></a>

            				<a href="#"><i class="fab fa-reddit-square"></i></a>

            				<a href="#"><i class="fas fa-ellipsis-h"></i></a>

                        </div>

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

    @php $showPanel = 'show'; @endphp

    @php $showPanelBtn = 'open'; @endphp

    @foreach($medias as $media)

        <div class="card">

            <div class="card-header">

                <button class="btn btn-link {{$showPanelBtn}}" type="button" data-toggle="collapse" data-target="#category{{$media->id}}" aria-expanded="true" aria-controls="collapseOne">

                    @if($media->icon)

                    <i class="fa {{$media->icon}}"></i>

                    @endif

                    {{$media->media_type}}
                </button>
                <div class="divider"></div>

            </div>

            <div class="collapse {{$showPanel}}" id="category{{$media->id}}" data-category="{{$media->id}}">

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

        @php $showPanel = ''; @endphp

        @php $showPanelBtn = ''; @endphp

    @endforeach

    </div>

    <br /><br />

    @include('stacks.related')


<div class="modal fade" id="popupComments" tabindex="-1" role="dialog" aria-labelledby="popupComments" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="popupComments">Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div



@endsection
