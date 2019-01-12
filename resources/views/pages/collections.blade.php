<div class="collections">

	<div class="title">Collections</div>

	<div class="row">

		@foreach($collections as $collection)

			<div class="col-md-3">

				@include('collections.box')

			</div>

		@endforeach

		<div class="col-md-3">

			<a class="add-collection"><i class="fa fa-plus"></i> Add New Collection </a>

		</div>

	</div>

</div>