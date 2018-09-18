<h2>Parking Lot <a href="/links/create"><i class="fa fa-plus-circle"></i></a></h2>

	<div class="row parking-container">

		@if (count($data['parking']) > 0)

			@foreach($data['parking'] as $parking)

				<div class="well">

					{{$parking->title}}

				</div>	


			@endforeach

		@endif

	</div>