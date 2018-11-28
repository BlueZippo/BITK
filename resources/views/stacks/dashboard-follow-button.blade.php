<div class="stack-dashboard-follow-button">
	@if ($follow)
		<a class="follow followed" data-id="{{$stack['id']}}" data-action="unfollow">
			<span><i class="fa fa-check-circle"></i> Following Stack</span>
			<span class="hover"><i class="fa fa-minus"></i> Unfollow Stack</span>
		</a>
	@else
		<a class="follow" data-id="{{$stack['id']}}" data-action="follow">
			<i class="fa fa-plus-circle"></i> Follow this Stack
		</a>
	@endif	
</div>