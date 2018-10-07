@extends ('layouts.master')

@section('content')

    <h2><a href="/stacks/explore">Explore</a></h2>            

    <hr />

    <form action="/stacks/search" method="POST" role="search">
    {{ csrf_field() }}
    <div class="row">
        <div class="input-group col-md-12">
            <input type="text" class="form-control" name="search" placeholder="Search stacks"> <span class="input-group-btn"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span></button>
            </span>
        </div>
    </div>
    </form>

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