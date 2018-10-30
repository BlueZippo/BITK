<div class="stack-panel">

	<div class="panel-heading"><h3><span>Tags</span> <a href="/tags/create" class="add-tag">Add a Tag</a></h3> </div>

	<div class="panel-body">

		<div class="row tags-container">

			<div class="col-md-12">


					@if (count($tags) > 0)

						@foreach($tags as $tag)

							<span class="tag" id="tag{{$tag->id}}" data-id="{{$tag->id}}">#{{$tag->tag}} <i class="fa fa-minus"></i></span>

						@endforeach

					@endif


			</div>

		</div>

	</div>

</div>
