<h2>Tags <a href="/tags/create" class="add-tag"><i class="fa fa-plus-circle"></i></a></h2>

	<div class="row tags-container">

		@if (count($data['tags']) > 0)

			@foreach($data['tags'] as $tag)

				<span>#{{$tag->tag}}</span>

			@endforeach

		@endif

	</div>	