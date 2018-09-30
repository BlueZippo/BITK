<h2>Stacks I'm Following</h2>

<div class="row">

	@if (count($follows) > 0)

		@foreach($follows as $follow)

			<div class="col-md-3">	

				<h3>{{$follow->stack->title}}</h3>
				<small>{{$follow->stack->subtitle}}</small>

			</div>	

		@endforeach	

	@endif;

</div>	