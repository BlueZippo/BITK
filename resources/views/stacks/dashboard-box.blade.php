<div class="inner-wrap dash-stack-tile">

    <div class="featured-image">
        <div class="gradient"></div>
        @if ($stack['image'])
            @if ($stack['media_type'] == 'youtube')
                <img src="http://img.youtube.com/vi/{{$stack['image']}}/hqdefault.jpg" />
            @else
                <img src="{{$stack['image']}}" />                
            @endif
        @else
            <img src="{{ asset('images/stack-placeholder.png') }}" />
        @endif

        <div class="title">
            <h4><a href="/stacks/{{$stack['id']}}/dashboard">{{$stack['title']}}</a></h4>
        </div>

    </div>

    <div class="stack-content">

        <div class="title" style="display: none;">
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
            <div class="name">
                {{$stack['author']['name']}}

                @if ($stack['author']['id'] != $user_id)
                    @if ($stack['author']['followed'])
                        <a id="author{{$stack['author']['id']}}" data-id="{{$stack['author']['id']}}" class="people-unfollow" title="Unfollow {{$stack['author']['name']}}"><i class="fas fa-user-check"></i></a>
                    @else
                        <a id="author{{$stack['author']['id']}}" data-id="{{$stack['author']['id']}}" class="people-follow" title="Follow {{$stack['author']['name']}}"><i class="fas fa-user-plus"></i></a>
                    @endif
                @endif
            </div>
        </div>

        <div class="stack-footer transition">
            <div class="edit">

                @if (Auth::user()->id == $stack['user_id'])

                    <a class="edit-dash-trigger" href="/stacks/{{$stack['id']}}/edit" target="_self">
                        <i class="fas fa-edit"></i> edit
                    </a>                    

                    <a class="trash trash-dash-trigger" data-id="{{$stack['id']}}">
                        <i class="fas fa-trash-alt"></i>
                    </a>

                @else


                    @if ($stack['follow'])

                        <a class="follow @if($stack['follow']) followed @endif" data-id="{{$stack['id']}}" data-action="unfollow">
                            <i class="fas fa-check-circle"></i>
                        </a>                    

                    @else

                        <a class="follow" data-id="{{$stack['id']}}" data-action="follow">
                            <i class="fas fa-plus-circle"></i>
                        </a>                    

                    @endif                    

                @endif

            </div>
            <div class="likes">
                <div class="forward forward-trigger"><i class="fas fa-share-square"></i></div>
                <div class="like" data-id="{{$stack['id']}}"><i class="fas fa-thumbs-up"></i> {{$stack['upvotes']}}</div>
                <div class="dislike" data-id="{{$stack['id']}}"><i class="fas fa-thumbs-down"></i> {{$stack['downvotes']}}</div>
            </div>
        </div>
    </div>

</div>
