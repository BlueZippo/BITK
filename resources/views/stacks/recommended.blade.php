<h2>Stacks Recommended for you</h2>

	<div class="row">

		@if (count($data['stacks']) > 0)

			@foreach($data['stacks'] as $stack)

				<div class="col-md-2">

					<a href="/stacks/{{$stack->id}}/dashboard">

					<h3>{{$stack->title}}</h3>
					<small>{{$stack->subtitle}}</small>					

					</a>

				</div>	

			@endforeach

		@endif
	</div>