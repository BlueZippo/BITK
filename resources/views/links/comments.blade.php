@if(Auth::check())
	@include('links.comments-form')
@endif

<div class="comment-list">
@include('links.comments-list')
</div>


