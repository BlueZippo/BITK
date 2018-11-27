<div class="stack-panel">

	<div class="panel-heading"><h3><span>Stacks</span> Recommended for you</h3></div>

	<div class="panel-body">

		<div class="row">

			@if (count($stacks) > 0)

				@foreach($stacks as $stack)

					<div class="col-md-2" id="stack{{$stack['id']}}">

						@include('stacks.dashboard-box')

					</div>

				@endforeach

			@else

			<div class="no-stacks"><p>Nothing recommended yet. Once you follow a Stack or a person, this section will show Stacks!</p></div>

			@endif

		</div>

	</div>

</div>
