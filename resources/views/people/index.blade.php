@extends ('layouts.master')

@section('content')

    <h2>People</h2>            

    <div class="row">
        
        @foreach($users as $user)

        <div class="col-md-2 text-center people-{{$user->id}}">

            <a href="/people/{{$user->id}}/stacks">

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

            </a>

            @if ($follows->contains($user->id))

            <input class="btn btn-primary follow-people-button" data-id={{$user->id}} value="Unfollow">

            @else

            <input class="btn btn-primary follow-people-button" data-id={{$user->id}} value="Follow">

            @endif

        </div>   


        @endforeach
        
    </div>    
   

@endsection