@extends ('layouts.master')

@section('style')

<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link href="{{ asset('css/stack-dashboard.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="dashboard">
        <div class="nav-wrapper">
            @include('pages.nav')
        </div>
    </div>


    @if (Auth::user()->id == $stack['user_id'])

    <div class="row">

        <div class="col-md-12">

            <div class="page-title-row">

                <div class="stack-controls single-stack">
                    <p class="edit-ctrl">Edit Options:</p>
                    <div class="stack-ctrl-item clone">
                        <svg width="38" height="18" xmlns="http://www.w3.org/2000/svg">
                          <g>
                            <path id="clone" d="M7.875 4.781V0H.844A.842.842 0 0 0 0 .844v16.312c0 .468.376.844.844.844h11.812a.842.842 0 0 0 .844-.844V5.625H8.719a.846.846 0 0 1-.844-.844zm2.25 8.297c0 .232-.19.422-.422.422H3.797a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.25c0 .232-.19.422-.422.422H3.797a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.531v.281c0 .232-.19.422-.422.422H3.797a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422zM13.5 4.286V4.5H9V0h.214c.225 0 .44.088.598.246l3.442 3.445a.841.841 0 0 1 .246.595zM31.746 4.781V0h-7.031a.842.842 0 0 0-.844.844v16.312c0 .468.376.844.844.844h11.812a.842.842 0 0 0 .844-.844V5.625H32.59a.846.846 0 0 1-.844-.844zm2.25 8.297c0 .232-.19.422-.422.422h-5.906a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.25c0 .232-.19.422-.422.422h-5.906a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.531v.281c0 .232-.19.422-.422.422h-5.906a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422zm3.375-4.011V4.5h-4.5V0h.215c.225 0 .439.088.597.246l3.442 3.445a.841.841 0 0 1 .246.595zM21.34 9l-4.852 4.184V4.816z" fill="#1DA1F2" fill-rule="nonzero" />
                          </g>
                        </svg>
                        <span>Clone</span>
                    </div>
                    <div class="stack-ctrl-item">
                        <i class="fas fa-trash-alt"></i>
                        <span>Trash</span>
                    </div>
                    <div class="stack-ctrl-item" onclick="editRedirect()">
                        <i class="fas fa-pen-square"></i>
                        <span>Edit</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        function editRedirect() {
            window.location = "/stacks/{{$stack->id}}/edit";
        }
    </script>

    @endif


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

                <div class="content-body">{!! html_entity_decode($stack->content) !!}</div>


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
