@extends ('layouts.master')

@section('content')

    <h2>People</h2>            

    <hr />

    <div class="row">
        
        @foreach($users as $person)

        <div class="col-md-2 text-center people-{{$person->id}}">

            @include('people.box')

        </div>   


        @endforeach
        
    </div>    
   

@endsection