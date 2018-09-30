<h2>Stacks I'm Following</h2>

<div class="row">

	@if (count($follows) > 0)

		@foreach($follows as $follow)

			<div class="col-md-3">	

				<a href="/stacks/{{$follow->stack->id}}/dashboard"><h3>{{$follow->stack->title}}</h3>
				<small>{{$follow->stack->subtitle}}</small></a>

			</div>	

		@endforeach	

	@endif;

</div>	