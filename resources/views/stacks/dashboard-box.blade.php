    <div class="inner-wrap" id="stack{{$stack['id']}}">
      

      <div class="stack-content">
        <div class="title">
            <a href="/stacks/{{$stack['id']}}/dashboard">{{$stack['title']}}</a>
        </div>

        

        <div class="author user-ctrl">
          <div class="avatar">
            @if ($stack['author']['photo'])
              <img src="{{$stack['author']['photo']}}">
            @else
              <div class="inner">
                {{ render_initials( $stack['author']['name'] ? $stack['author']['name'] : $stack['author']['email']   ) }}
              </div>
            @endif
          </div>
          {{$stack['author']['name']}}
        </div>

        <div class="stack-footer">
            <a class="btn btn-primary" href="/stacks/{{$stack['id']}}/dashboard">Start Learning</a>
            @if ($stack['user_id'] == $user_id)
            <br />
            <a class="btn btn-primary" href="/stacks/{{$stack['id']}}/edit">Edit Stack</a>
            @endif
        </div>
      </div>
    </div>
