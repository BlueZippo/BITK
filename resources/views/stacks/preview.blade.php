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

    






@endsection
