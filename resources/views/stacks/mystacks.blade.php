<div class="panel panel-default">

	<div class="panel-heading">My Stacks</div>

	<div class="panel-body">

		<div class="row my-links">

			<div class="col-md-2 text-center">

				<a href="/stacks/create" class="btn btn-primary btn-circle btn-xl create-stack-button"><i class="fa fa-plus"></i></a>

				
			</div>

			<div class="col-md-8">	

				@if (count($mystacks) > 0)

					
					<div class="row">
						@foreach($mystacks as $stack)
							<div class="col-md-4">
								<div class="well">
									<a href="/stacks/{{$stack->id}}/dashboard">
										<h4>{{$stack->title}}</h4>
										<small>{{$stack->subtitle}}</small>
									</a>
									<div class="buttons">

										<form method="post" action="/stacks/delete">

											<input type="hidden" name="stack_id" value="{{$stack->id}}">

											<a href="/stacks/{{$stack->id}}/edit">Edit</a> | <a class="delete-button">Delete</a>

										</form>

									</div>
								</div>
							</div>
						@endforeach
					</div>
					
				@endif

			</div>
			
			<div class="col-md-2">	

				<a href="" class="set-link-reminder btn btn-primary">Set a reminder on a link</a>

			</div>	

		

			

		

		</div>

		<div class="row">

			<div class="col-md-12 text-center">

					<a class="view-all btn btn-primary" href="/stacks/view-all">View All</a>

			</div>

		</div>

	</div>

</div>