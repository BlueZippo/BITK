@extends ('layouts.master')

@section('content')

    <h2><a href="/stacks/explore">Explore</a></h2>            

    <hr />

    <div class="row">

        <div class="col-md-3">

            @include('stacks.media-type')


        </div>
        
        <div class="col-md-9">    

            <div class="row">

                @foreach($stacks as $stack)

                <div class="col-md-4">

                    @include('stacks.box')

                </div>


                @endforeach

            </div>
            
         </div>       
        
        
    </div>    
   

@endsection