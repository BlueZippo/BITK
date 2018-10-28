<div class="stack-panel">

	<div class="panel-heading"><h3><span>Stacks</span> I'm Following</h3></div>

	<div class="panel-body">

		@if (count($follows) > 0)

			<div class="row">

			@foreach($follows as $stack)

				<div class="col-md-2">

					@include('stacks.dashboard-box')

				</div>

			@endforeach

			</div>

	@endif

	</div>

</div>
