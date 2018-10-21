@extends ('layouts.master')

@section('content')

    <h2>{{$user->name}}</h2>            

    <hr />

    <div class="row">

        @foreach($stacks as $stack)

        <div class="col-md-3">

            @include('stacks.box')

        </div>


        @endforeach
        
        
    </div>    
   

@endsection