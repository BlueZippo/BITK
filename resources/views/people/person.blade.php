@extends ('layouts.master')

@section('content')

<div class="nav-wrapper">
    @include('pages.nav')
</div>

<div id="profile-page">

    <div class="profile-page-header">

        <div class="profile-header_top">

            <div class="container">

                <div class="row">

                    <div class="col-md-12">

                        <div class="inner">
                            <h2>{{$user->name}}</h2>
                            <h4>{{'@'.$user->instagram}}</h4>
                            <p>{{$user->profile}}</p>
                        </div>


                    </div>

                </div>

            </div>

        </div>

        <div class="profile-header_bottom">


        </div>

    </div>

</div>

@php var_dump($user) @endphp


@endsection
