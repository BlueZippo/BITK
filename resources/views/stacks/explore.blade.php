@extends ('layouts.master')

@section('content')

    @if (Auth::check())

        <h2><a href="/stacks/explore">Explore</a></h2>


    @else

        <h2><a href="/">Explore</a></h2>            

    @endif    

    <hr />

    <div class="row">

        @foreach($stacks as $stack)

            <div class="col-md-2">

                    @include('stacks.box')

            </div>


    @endforeach

        
        
    </div>    
   

@endsection