<div class="panel panel-default">

	<div class="panel-heading">Stacks Recommended for you</div>

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
