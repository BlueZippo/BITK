<h2>Stacks I'm Following</h2>

<div class="row">

	@if (count($data['follows']) > 0)

		@foreach($data['follows'] as $follow)

			<div class="col-md-3">	

				<h3>{{$follow->title}}</h3>
				<small>{{$follow->subtitle}}</small>

			</div>	

		@endforeach	

	@endif;

</div>	