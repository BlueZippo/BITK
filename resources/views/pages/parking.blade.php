<h2>Parking Lot <a href="/links/create"><i class="fa fa-plus-circle"></i></a></h2>

	<div class="row parking-container">

		@if (count($parking) > 0)

			@foreach($parking as $parking)

					<div class="col-md-12">

						<div class="card card-body">

							<a href="{{$parking->link}}" target="_blank">{{$parking->title}}</a>
							<div class="meta small"><a data-action="edit" href="/links/{{$parking->id}}/edit">Edit</a> | <a data-id="{{$parking->id}}" data-action="delete">Delete</a> </div>

						</div>	

					</div>			


			@endforeach

		@endif

	</div>