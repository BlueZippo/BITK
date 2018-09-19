<h2>Parking Lot <a href="/links/create"><i class="fa fa-plus-circle"></i></a></h2>

	<div class="row parking-container">

		@if (count($data['parking']) > 0)

			@foreach($data['parking'] as $parking)



					<div class="col-md-12">

						<div class="card card-body">

							{{$parking->title}}

						</div>	

					</div>

				


			@endforeach

		@endif

	</div>