@if ($stack->media_type == 'youtube')

<iframe width="100%" height="350" src="https://www.youtube.com/embed/{{$stack->video_id}}?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

@else

<div class="featured-image-upload stack"><img width="100%" height="350" src="{{$stack->video_id}}" /></div>

@endif
