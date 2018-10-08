<h2>My Stacks</h2>

	<div class="row my-links">

		<div class="col-md-4">

			<a href="/stacks/create" class="create-link">	<span>Create a Stack</span></a>

		</div>

		<div class="col-md-4">	

			@if (count($mystacks) > 0)
				<div class="row">
					@foreach($mystacks as $stack)
						<div class="col-md-4">
							<a href="/stacks/{{$stack->id}}/dashboard">
								<h3>{{$stack->title}}</h3>
								<small>{{$stack->subtitle}}</small>
							</a>
							<div class="buttons">

								<form method="post" action="/stacks/delete">

									<input type="hidden" name="stack_id" value="{{$stack->id}}">

									<a href="/stacks/{{$stack->id}}/edit">Edit</a> | <a class="delete-button">Delete</a>

								</form>

							</div>
						</div>
					@endforeach
				</div>
			@endif

		</div>
		
		<div class="col-md-4">	

			<a class="set-link-reminder">Set a reminder on a link</a>

		</div>	

	

		<div class="col-md-12 text-center">

				<a class="view-all" href="/stacks/view-all">View All</a>

		</div>

	

	</div>