<div class="panel panel-default">

	<div class="panel-heading">Parking Lot <a href="/links/create"><i class="fa fa-plus-circle"></i></a></div>

	<div class="panel-body">

			

			@if (count($parking) > 0)

				@foreach($parking as $parking)

					<div class="row parking-container">

						<div class="col-md-12">

							<div class="well">

								<a href="{{$parking->link}}" target="_blank">{{$parking->title}}</a>

								<div class="meta small">
									<a data-action="edit" href="/links/{{$parking->id}}/edit">Edit</a> | <a data-id="{{$parking->id}}" data-action="delete">Delete</a> 
								</div>

							</div>	

						</div>			

					</div>	


				@endforeach

			@endif

		

	</div>
	
</div>		