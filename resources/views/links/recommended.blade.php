<h2>Links Recommended for you</h2>

	<div class="row">

		@if (count($data['links']) > 0)

			@foreach($data['links'] as $link)

				<div class="col-md-2">

					<h3>{{$link->title}}</h3>
					<small>{{$link->subtitle}}</small>

					<a class="follow-button" data-id="{{$link->id}}"><i class="fas fa-plus-circle"></i></a>

				</div>	

			@endforeach

		@endif
	</div>