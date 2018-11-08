@extends ('layouts.master')

@section('content')

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