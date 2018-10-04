@extends ('layouts.master')

@section('content')

    <h2>Explore</h2>            

    <hr />

    <div class="row">

        @foreach($stacks as $stack)

        <div class="col-md-4">

            <a href="/stacks/{{$stack->id}}/dashboard">
                <h3>{{$stack->title}}</h3>
                <small>{{$stack->subtitle}}</small>
            </a>

        </div>


        @endforeach
        
        
    </div>    
   

@endsection