
@include('pages.avatar')

<div class="name">{{$person->name}}</div>

@if ($person->instagram)
<div class="handle">{{'@'.$person->instagram}}</div>
@endif

@if (in_array($person->id, $following->pluck('user_id')->toArray()))

<a href="#" class="btn btn-primary">Following</a>

@endif

<a href="#">...</a>