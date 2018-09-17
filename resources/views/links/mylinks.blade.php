<h2>My Links</h2>

	<div class="row my-links">

		<div class="col-md-4">

			<a href="/links/create" class="create-link">	<span>Create a Link</span></a>

		</div>

		<div class="col-md-4">	

			@if (count($data['mylinks']) > 0)
				<div class="row">
					@foreach($data['mylinks'] as $link)
						<div class="col-md-4">
							<h3>{{$link->title}}</h3>
							<small>{{$link->subtitle}}</small>
						</div>
					@endforeach
				</div>
			@endif

		</div>
		
		<div class="col-md-4">	

			<a class="set-link-reminder">Set a reminder on a link</a>

		</div>	

	

		<div class="col-md-12 text-center">

				<a class="view-all">View All</a>

		</div>

	

	</div>