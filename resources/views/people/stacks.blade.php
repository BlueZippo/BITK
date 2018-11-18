@extends ('layouts.master')

@section('content')

	<div class="dashboard">
        <div class="nav-wrapper">
            @include('pages.nav')
        </div>
    </div>

    <h2>{{$user->name}}</h2>            

    <hr />



    <div class="stack-list tile">

        @foreach($stacks as $stack)

        <div class="single-stack-wrapper">

            @include('stacks.box')

        </div>


        @endforeach
        
        
    </div>    
   

@endsection