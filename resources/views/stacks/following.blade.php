<div class="dragdrop-target" data-id="dashboard-stacks-following">
	<div class="stack-panel dragdrop">

		<div class="panel-heading"><h3><span>Stacks</span> I'm Following</h3></div>

		<div class="panel-body">

			<div class="row">

			@if (count($follows) > 0)

				@foreach($follows as $stack)

					<div class="col-md-2" id="stack{{$stack['id']}}">

						@include('stacks.dashboard-box')

					</div>

				@endforeach

			@else

				<div class="no-stacks"><p>You're not following any Stacks, <a href="/stacks/explore" target="_self">explore people's Stacks</a> to find something you'd like.</p></div>

			@endif

			</div>

		</div>

	</div>
</div>
