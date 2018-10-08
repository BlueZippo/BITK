@extends ('layouts.master')

@section('content')

	<div class="row">

        @foreach($stacks as $stack)

        <div class="col-md-3">

            <h3><a href="/stacks/{{$stack->id}}/dashboard">{{$stack->title}}</a></h3>


        </div>


        @endforeach


    </div>
   

@endsection