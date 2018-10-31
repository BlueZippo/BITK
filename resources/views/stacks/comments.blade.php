@if(Auth::check())
	@include('stacks.comments-form')
@endif

<div class="comment-list">
@include('stacks.comments-list')
</div>


