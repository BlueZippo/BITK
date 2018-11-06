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

        <div class="stack-footer transition">
            <div class="edit">

                @if (Auth::user()->id == $stack['user_id'])

                <a href="/stacks/{{$stack['id']}}/edit" target="_self">
                    <i class="fas fa-edit"></i> edit
                </a>

                @endif

            </div>
            <div class="likes">
                <div class="forward forward-trigger"><i class="fas fa-share-square"></i></div>
                <div class="like"><i class="fas fa-thumbs-up"></i> 0</div>
                <div class="dislike"><i class="fas fa-thumbs-down"></i> 0</div>
            </div>
        </div>
    </div>

</div>
