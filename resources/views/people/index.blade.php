@extends ('layouts.master')

@section('content')

<div class="nav-wrapper">
    @include('pages.nav')
</div>

    <div class="people-page">

        <div class="page-title-row">
            <h2>People</h2>
        </div>

        <div class="row">

            @foreach($users as $person)

            <div class="col-md-2 people-{{$person->id}}">

                @include('people.box')

            </div>


            @endforeach

        </div>

    </div>


@endsection
