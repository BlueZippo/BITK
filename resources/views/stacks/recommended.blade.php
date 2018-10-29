<div class="stack-panel">

	<div class="panel-heading"><h3><span>Stacks</span> Recommended for you</h3></div>

	<div class="panel-body">

		<div class="row">

			@if (count($stacks) > 0)

				@foreach($stacks as $stack)

					<div class="col-md-2">

						@include('stacks.dashboard-box')

					</div>

				@endforeach

			@endif
		</div>

	</div>

</div>
