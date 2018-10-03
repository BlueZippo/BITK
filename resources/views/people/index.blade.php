@extends ('layouts.master')

@section('content')

    <h2>People</h2>            

    <div class="row">
        
        @foreach($users as $user)

        <div class="col-md-2 text-center people-{{$user->id}}">

            <div class="image-container">
                @if ($user->photo)
                <img src="/upload/{{$user->photo}}">
                @else
                <img src="/upload/no-image.png">
                @endif
            </div>

            <div class="name-container">
                {{$user->name}}
            </div>    

            <input class="btn btn-primary follow-people-button" data-id={{$user->id}} value="Follow">

        </div>   


        @endforeach
        
    </div>    
   

@endsection