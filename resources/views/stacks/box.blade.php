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

        <div class="meta-category">
          <div class="categories">{{$stack['categories']}}</div>
          <div class="date">{{$stack['updated_at']}}</div>
        </div>

        <div class="author user-ctrl">
          <div class="avatar">
            @if ($stack['author']['photo'])
              <img src="{{$stack['author']['photo']}}">
            @else
              <div class="inner">
                
              </div>
            @endif
          </div>
          by: {{$stack['author']['name']}}
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
