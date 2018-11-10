<div class="youtube">

  @if (old('video_id'))

    @include('stacks.youtube-frame');

  @elseif (isset($stack->video_id) && $stack->video_id)  

    @if ($stack->media_type == 'youtube')

      @include('stacks.youtube-frame2')  

    @else

      @include('stacks.image')

    @endif

  @else

  <a class="click-here"  data-toggle="modal" data-target="#youtubeModal"></a>

  @endif

</div>

