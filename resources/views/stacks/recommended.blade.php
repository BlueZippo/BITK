<h2>Stacks Recommended for you</h2>

	<div class="row">

		@if (count($data['stacks']) > 0)

			@foreach($data['stacks'] as $stack)

				<div class="col-md-2">

					<h3>{{$stack->title}}</h3>
					<small>{{$stack->subtitle}}</small>

					<a class="follow-button" data-id="{{$stack->id}}"><i class="fas fa-plus-circle"></i></a>

				</div>	

			@endforeach

		@endif
	</div>