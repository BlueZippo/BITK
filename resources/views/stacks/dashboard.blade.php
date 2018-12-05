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

    @if (Auth::check())

    @if (Auth::user()->id == $stack['user_id'])

    <div class="row">

        <div class="col-md-12">

            <div class="page-title-row">

                <div class="stack-controls single-stack">
                    <p class="edit-ctrl">Edit Options:</p>
                    <div class="stack-ctrl-item clone" data-id="{{$stack['id']}}">
                        <svg width="38" height="18" xmlns="http://www.w3.org/2000/svg">
                          <g>
                            <path id="clone" d="M7.875 4.781V0H.844A.842.842 0 0 0 0 .844v16.312c0 .468.376.844.844.844h11.812a.842.842 0 0 0 .844-.844V5.625H8.719a.846.846 0 0 1-.844-.844zm2.25 8.297c0 .232-.19.422-.422.422H3.797a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.25c0 .232-.19.422-.422.422H3.797a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.531v.281c0 .232-.19.422-.422.422H3.797a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422zM13.5 4.286V4.5H9V0h.214c.225 0 .44.088.598.246l3.442 3.445a.841.841 0 0 1 .246.595zM31.746 4.781V0h-7.031a.842.842 0 0 0-.844.844v16.312c0 .468.376.844.844.844h11.812a.842.842 0 0 0 .844-.844V5.625H32.59a.846.846 0 0 1-.844-.844zm2.25 8.297c0 .232-.19.422-.422.422h-5.906a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.25c0 .232-.19.422-.422.422h-5.906a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.531v.281c0 .232-.19.422-.422.422h-5.906a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422zm3.375-4.011V4.5h-4.5V0h.215c.225 0 .439.088.597.246l3.442 3.445a.841.841 0 0 1 .246.595zM21.34 9l-4.852 4.184V4.816z" fill="#1DA1F2" fill-rule="nonzero" />
                          </g>
                        </svg>
                        <span>Clone</span>
                    </div>
                    <div class="stack-ctrl-item trash" data-id="{{$stack['id']}}">
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

    @else

        @include('stacks.dashboard-follow-button')
    

    @endif

    @endif


    <div class="stack-wrapper">

        <div class="row">

    		<div class="col-md-7 content">

                <h2 class="stack-title">{{$stack->title}}</h2>
                <div class="stack-meta">
                    <div class="meta-topics">
                        <p><strong>Under Topic:</strong> <span>{{$topics}}</span></p>
                    </div>
                    <div class="meta-date-comments">
                        <div class="date"><p>Updated: {{date("M d, Y", strtotime($stack->updated_at))}}</p></div>
                        <div class="comments" data-id="{{$stack['id']}}"><p><i class="fas fa-comment-dots"></i> {{$comments}} Comments</p></div>
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


                        <p>

                            {{$stack->user->name}} 

                            @if ($authorFollow)
                                <a id="author{{$stack->user_id}}"  data-id="{{$stack->user_id}}" class="people-unfollow" title="Unfollow {{$stack->user->name}}"><i class="fas fa-user-check"></i></a>
                            @else
                                <a id="author{{$stack->user_id}}"  data-id="{{$stack->user_id}}" class="people-follow" title="Follow {{$stack->user->name}}"><i class="fas fa-user-plus"></i></a>
                            @endif

                        </p>

                    </div>


                    <div class="stack-rate col-md-6">

                        <div class="likes">

                            @if (Auth::check())

                                <a class="upvote" data-id="{{$stack->id}}"><i class="fas fa-thumbs-up"></i> {{$upvote}}</a>

                                <a class="downvote" data-id="{{$stack->id}}"><i class="fas fa-thumbs-down"></i></a>

                            @else

                                <a class="upvote non-user" data-id="{{$stack->id}}"><i class="fas fa-thumbs-up"></i> {{$upvote}}</a>

                                <a class="downvote non-user" data-id="{{$stack->id}}"><i class="fas fa-thumbs-down"></i></a>

                            @endif

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

                        <img src="{{ asset('images/stack-placeholder.png') }}">

                    </div>


                @endif



            </div>

    	</div>

    </div>

    <div class="edit-stack-layout-controls stack-layout-controls"> <!-- https://getbootstrap.com/docs/4.1/components/navs/ -->
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">

                <a class="nav-item nav-link" id="nav-layout-tabbed" data-toggle="tab" href="#layout-tabbed" role="tab" aria-controls="nav-tabbed" aria-selected="false"><i class="far fa-folder"></i></a>

                <a class="nav-item nav-link active" id="nav-layout-accordion" data-toggle="tab" href="#layout-accordion" role="tab" aria-controls="nav-accordion" aria-selected="true"><i class="fas fa-list-ul"></i></a>

            </div>
        </nav>
    </div>

    <div class="tab-content" id="nav-create-layout">

        <!-- Tabbed View -->
        <div class="tab-pane fade" id="layout-tabbed" role="tabpanel" aria-labelledby="nav-layout-tabbed">

            @include('stacks.tab-links')

        </div>

        <!-- Accordion View -->
        <div class="tab-pane fade show active" id="layout-accordion" role="tabpanel" aria-labelledby="nav-layout-accordion">

            @include('stacks.accordion-links')

        </div>

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
</div>



@endsection
