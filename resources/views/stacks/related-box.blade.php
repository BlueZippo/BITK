    <div class="inner-wrap" id="stack{{$stack['id']}}">
      <div class="featured-image">
        @if ($stack['image'])
            @if ( is_image($stack['image']) )
                <img src="{{$stack['image']}}" />
            @else
                <img src="http://img.youtube.com/vi/{{$stack['image']}}/hqdefault.jpg">
            @endif
        @else
            <img src="{{ asset('images/stack-placeholder.png') }}">
        @endif
      </div>

      <div class="stack-content">
        <div class="title">
            <a href="/stacks/{{$stack['id']}}/dashboard">{{$stack['title']}}</a>
        </div>




        <div class="stack-footer">
          @if (Auth::check())
            @if ($stack['follow'])
              <a class="follow-button" data-action="unfollow" data-id="{{$stack['id']}}"><i class="fa fa-plus"></i> Saved</a>
            @else
              <a class="follow-button" data-action="follow" data-id="{{$stack['id']}}"><i class="fa fa-plus"></i> Save</a>
            @endif
          @endif
        </div>
      </div>
    </div>
