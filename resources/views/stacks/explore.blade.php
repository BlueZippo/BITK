@extends ('layouts.master')

@section ('view')

    <div class="view-button">

        <a class="tile">
            <span></span>
            <span></span>
        </a>

        <a class="compact">
            <span></span>
            <span></span>            
            <span></span>
        </a>

        <a class="list">            
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </a>

    </div>

@endsection

@section('content')

   

    <div class="stack-list tile">

        @foreach($stacks as $stack)

            <div class="single-stack-wrapper">

                    @include('stacks.box')

            </div>


        @endforeach
        
        
    </div>    
   

@endsection