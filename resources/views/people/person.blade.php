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

    </div>

</div>

<divclass="row">

    @php $ctr = 0; @endphp

    @foreach($stacks as $stack)

        @php

            $ctr++

        @endphp

        <div class="col-md-12">
            <div>
                <div>{{$stack['media']}}</div>
                <div><h4>{{$stack['title']}} {{$ctr}}</h4></div>
                <div></div>
            </div>
        </div>

    @endforeach

</div>

@foreach($stacks as $stack)

@php //var_dump($stack) @endphp

@endforeach

@php //var_dump($stacks) @endphp

@php //var_dump($user) @endphp


@endsection
