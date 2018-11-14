    <div class="inner-wrap" id="stack{{$stack['id']}}">

      <div class="list-button">

        <a class="approve-button" data-id="{{$stack['id']}}"><i class="fa fa-arrow-up"></i></a>

        <span class="upvotes">{{$stack['upvotes']}}</span>

        <a class="disapprove-button" data-id="{{$stack['id']}}"><i class="fa fa-arrow-down"></i></a>

      </div>

      <div class="featured-image @if(!$stack['image']) no-image @endif">
        @if ($stack['image'])

          @if ($stack['media_type'] == 'youtube')
            <img src="http://img.youtube.com/vi/{{$stack['image']}}/hqdefault.jpg">
          @else
            <img src="{{$stack['image']}}">
          @endif
        @else
            <img src="{{ asset('images/stack-placeholder.png') }}">
        @endif
      </div>

      <div class="compact-button">
        <a class="follow-button">Follow</a>
        <span class="more-button">
          <i class="fa fa-ellipsis-v"></i>
          <div class="more-container">

            <a title="Add to favorites" class="like-button" data-action="like" data-id={{$stack['id']}}><i class="fa fa-heart"></i> Add to favorites</a>
            <a title="Send stack" class="share-button" data-action="share" data-id={{$stack['id']}}><i class="fa fa-share"></i> Send</a>
            <a title="Like stack" class="approve-button" data-action="approve" data-id={{$stack['id']}}><i class="fa fa-thumbs-up"></i> {{$stack['upvotes']}}</a>
            <a title="Unlike stack" class="disapprove-button" data-action="disapporve" data-id={{$stack['id']}}><i class="fa fa-thumbs-down"></i> {{$stack['downvotes']}}</a>
            <a title="Add comments" class="comments-button" data-action="comments" data-id={{$stack['id']}}><i class="fa fa-comments"></i> {{$stack['comments']}}</a>


                <a class="Set reminder"><i class="fa fa-clock-o"></i> Set a reminder</a>
                <a class="Hide hide-button" data-id="{{$stack['id']}}"><i class="fa fa-times"></i> Hide<small>See fewer stacks like this</small></a>
                <a class="Report"><i class="fa fa-ban"></i> Report<small>This goes agains Platstack's community guidelines</small></a>
          </div>
        </span>
      </div>

      <div class="compact-author user-ctrl">
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



      <div class="stack-content">
        <div class="title">
            <a href="/stacks/{{$stack['id']}}/dashboard">{{$stack['title']}}</a>
        </div>

        <div class="meta-category">
          <div class="categories">
            {{$stack['categories']}}
          </div>
          <div class="date">
            {{$stack['updated_at']}}
          </div>
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
          by: {{$stack['author']['name']}}
        </div>

        <div class="stack-footer">
          @if (Auth::check())
            @if ($stack['follow'])
              <a title="Follow stack" class="follow-button followed" data-action="unfollow" data-id="{{$stack['id']}}"><i class="fa fa-plus-circle"></i></a>
            @else
              <a  title="Follow stack" class="follow-button" data-action="follow" data-id="{{$stack['id']}}"><i class="fa fa-plus-circle"></i></a>
            @endif
            @if ($stack['favorite'])
              <a title="Add to favorites" class="like-button favorite" data-action="unlike" data-id={{$stack['id']}}><i class="fa fa-heart"></i></a>
            @else
              <a title="Add to favorites" class="like-button" data-action="like" data-id={{$stack['id']}}><i class="fa fa-heart"></i></a>
            @endif
            <a title="Send stack" class="share-button" data-action="share" data-id={{$stack['id']}}><i class="fa fa-share"></i></a>
            <a title="Like stack" class="approve-button" data-action="approve" data-id={{$stack['id']}}><i class="fa fa-thumbs-up"></i> {{$stack['upvotes']}}</a>
            <a title="Unlike stack" class="disapprove-button" data-action="disapporve" data-id={{$stack['id']}}><i class="fa fa-thumbs-down"></i> {{$stack['downvotes']}}</a>
            <a title="Add comments" class="comments-button" data-action="comments" data-id={{$stack['id']}}><i class="fa fa-comments"></i> {{$stack['comments']}}</a>
            <span title="More action" class="more-button" data-action="more" data-id={{$stack['id']}}>
              <i class="fa fa-ellipsis-h"></i>
              <div class="more-container">
                <a class="Send stack share-button"><i class="fa fa-upload"></i> Send</a>

                @if ($stack['follow'])
                  <a title="Follow stack" class="follow-button followed" data-action="unfollow" data-id="{{$stack['id']}}"><i class="fa fa-plus-circle"></i> Followed</a>
                @else
                  <a  title="Follow stack" class="follow-button" data-action="follow" data-id="{{$stack['id']}}"><i class="fa fa-plus-circle"></i> Follow</a>
                @endif


                @if ($stack['favorite'])
                  <a class="Add to favorites like-button favorite"><i class="fa fa-heart"></i> Added to favorites</a>
                @else
                  <a class="Add to favorites like-button"><i class="fa fa-heart"></i> Add to favorites</a>
                @endif
                <a class="Set reminder"><i class="fa fa-clock-o"></i> Set a reminder</a>
                <a class="Hide hide-button" data-id={{$stack['id']}}><i class="fa fa-times"></i> Hide<small>See fewer stacks like this</small></a>
                <a class="Report"><i class="fa fa-ban"></i> Report<small>This goes agains Platstack's community guidelines</small></a>
              </div>
            </span>
          @endif
        </div>
      </div>
    </div>
