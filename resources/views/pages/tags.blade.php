<div class="panel panel-default">
	
	<div class="panel-heading">Tags <a href="/tags/create" class="add-tag"><i class="fa fa-plus-circle"></i></a></div>

	<div class="panel-body">

		<div class="row tags-container">

			<div class="col-md-12">

		
					@if (count($tags) > 0)

						@foreach($tags as $tag)

							<span>#{{$tag->tag}}</span>

						@endforeach

					@endif


			</div>

		</div>	

	</div>	

</div>	