<div class="dragdrop-target">

	<div class="stack-panel dragdrop" data-id="dashboard-tags">

		<div class="panel-heading"><h3><span>Tags</span></h3> <a href="/tags/create" class="add-tag">Add a Tag</a></div>

		<div class="panel-body">

			<div class="row tags-container">

						@if (count($tags) > 0)

							<div class="col-md-12">

							@foreach($tags as $tag)

								<span class="tag" id="tag{{$tag->id}}" data-id="{{$tag->id}}">#{{$tag->tag}} <i class="fa fa-minus"></i></span>

							@endforeach

						</div>

						@else


						<div class="no-stacks"><p>No Tags yet! Add one you'll like.</p></div>


						@endif

			</div>

		</div>

	</div>

</div>
