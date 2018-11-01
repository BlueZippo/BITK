<div class="inner-wrap dash-stack-tile" id="stack{{$stack['id']}}">

    <div class="stack-content">
        <div class="title">
            <h4><a href="/stacks/{{$stack['id']}}/dashboard">{{$stack['title']}}</a></h4>
        </div>

        <div class="author user-ctrl">
            <div class="avatar">
                @if ($stack['author']['photo'])
                    <img src="{{$stack['author']['photo']}}">
                @else
                <div class="inner">{{ render_initials( $stack['author']['name'] ? $stack['author']['name'] : $stack['author']['email']   ) }}</div>
                @endif
            </div>
            <div class="name">{{$stack['author']['name']}}</div>
        </div>

        <div class="stack-footer">
            <a class="btn btn-primary" href="/stacks/{{$stack['id']}}/dashboard">Start Learning</a>
        </div>
    </div>

</div>
