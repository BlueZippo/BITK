    <div class="inner-wrap" id="stack{{$stack['id']}}">
      <div class="featured-image">
        @if ($stack['image'])
            <img src="http://img.youtube.com/vi/{{$stack['image']}}/hqdefault.jpg">
        @else
            <img src="/images/intheknow.png">
        @endif
      </div>

      <div class="stack-content">
        <div class="title">
            <a href="/stacks/{{$stack['id']}}/dashboard">{{$stack['title']}}</a>
        </div>

       


        <div class="stack-footer">
          @if ($stack['follow'])
            <a class="follow-button" data-action="unfollow" data-id="{{$stack['id']}}"><i class="fa fa-plus"></i> Saved</a>
          @else
            <a class="follow-button" data-action="follow" data-id="{{$stack['id']}}"><i class="fa fa-plus"></i> Save</a>
          @endif
        </div>
      </div>
    </div>
