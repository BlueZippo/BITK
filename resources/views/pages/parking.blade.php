<div class="stack-panel parking-lot-container">

	<div class="panel-heading">

		<h3><span>Parking</span> Lot</h3> <a class="add-a-link-button">Add a Link</a> @include('stacks.reminder')

	</div>

	@include('links.parking-form')

	<div class="panel-body">

			@if (count($parking) > 0)

				@foreach($parking as $parking)

					<div class="row parking-container" id="link{{$parking->id}}">

						<div class="col-md-2 link-image">

							<img src="{{$parking->image}}">

						</div>

						<div class="col-md-10">

							<div class="link-data">

								<h3><a href="@if($parking->code) {{config('APP_URL') . '/x/' . $parking->code}} @else {{$parking->link}} @endif" target="_blank">{{$parking->title}}</a></h3>

								<div class="host">

									{{$parking->get_host($parking->link)}}

								</div>

								<div class="meta small">

									<a class="edit-link" data-id={{$parking->id}}>Edit</a> | <a class="delete-link" data-id="{{$parking->id}}">Delete</a>

								</div>

							</div>

						</div>

						

					</div>


				@endforeach

			@endif



	</div>

</div>
