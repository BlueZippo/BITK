@foreach($comments as $comment)
<div class="row">
	<div class="col-md-2">
		<div class="avatar">
			@if ($comment->user->photo)
            <img src="{{$comment->user->photo}}">
            @else
            <div class="inner">{{ render_initials( isset($comment->user->name) ? $comment->user->name : $comment->user->email ) }}</div>
            @endif

		</div>	
	</div>
	<div class="col-md-10">	
		<div class="comment-comments">
			{{$comment->comments}}
		</div>
		<span class="small comment-date">{{date("M d, Y H:i", strtotime($comment->updated_at))}}</span>
	</div>
</div>
@endforeach