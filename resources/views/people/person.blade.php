@extends ('layouts.master')

@section('content')

<div class="nav-wrapper">
    @include('pages.nav')
</div>

<div id="profile-page">

    <div class="profile-page-header">

        @if($user->background)

        <div class="profile-header_top background" style="background-image:url({{$user->background}});">

        @else

        <div class="profile-header_top">

        @endif

            <div class="container">

                <div class="row">

                    <div class="col-md-12">

                        <div class="inner">
                            <h2>{{$user->name}}</h2>

                            @if($user->instagram)
                            <h4>{{'@'.$user->instagram}}</h4>
                            @endif

                            <p>{{$user->profile}}</p>
                        </div>


                    </div>

                </div>

            </div>

        </div>

        <div class="profile-header_bottom">

                <div class="inner">

                    @if($user->photo)
                    <div class="avatar"><img src="{{$user->photo}}" alt="{{$user->name}}" /></div>
                    @else
                    <div class="avatar no-image"></div>
                    @endif

                </div>

        </div>

    </div><!-- .profile-page-header -->

    <div id="profile-stacks">

        <div class="row">

            @php $ctr = 0; @endphp

            @foreach($stacks as $stack)

                @php $ctr++ @endphp

                @if($ctr == 1)
                    <div class="col-md-12">
                    @php $class = "main-stack" @endphp
                @else
                    <div class="col-md-4">
                    @php $class = "" @endphp
                @endif

                    <div class="stack {{$class}}">

                        @if(is_image($stack['media']))
                            <div class="header"><img src="{{$stack['media']}}" alt="{{$stack['title']}}" /></div>
                        @elseif($stack['media'] == '0')
                            <div class="header"><img src="{{asset('images/stack-placeholder.png')}}" alt="{{$stack['title']}}" /></div>
                        @else
                            <div class="header"><img src="http://i3.ytimg.com/vi/{{$stack['media']}}/hqdefault.jpg" alt="{{$stack['title']}}" /></div>
                        @endif
                        <div class="content">
                            <div class="title"><h4>{{$stack['title']}}</h4></div>
                            <div class="footer">
                                <div class="left">
                                    <div class="ctrl"><span><i class="fas fa-plus-circle"></i></span></div>
                                    <div class="ctrl favorite"><span><i class="fas fa-heart"></i></span></div>
                                    <div class="ctrl share"><span><i class="fas fa-share"></i></span></div>
                                    <div class="ctrl views"><span><i class="fas fa-eye"></i> 1,234</span></div>
                                </div>
                                <div class="right">
                                    <div class="ctrl like"><span><i class="fas fa-thumbs-up"></i> 436</span></div>
                                    <div class="ctrl unlike"><span><i class="fas fa-thumbs-down"></i> 23</span></div>
                                    <div class="ctrl"><span><i class="fas fa-comments"></i> 16</span></div>
                                    <div class="ctrl more"><span><i class="fas fa-ellipsis-h"></i></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($ctr == 1 || $ctr == 4)
                    </div>
                    <div class="row">
                @endif

                @if($ctr == 4)
                    @php $ctr = 1 @endphp
                @endif

            @endforeach

        </div>

    </div>

</div>

@foreach($stacks as $stack)

@php //var_dump($stack) @endphp

@endforeach

@php //var_dump($stacks) @endphp

@php //var_dump($user) @endphp


@endsection
