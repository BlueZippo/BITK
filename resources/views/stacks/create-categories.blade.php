<div class="categories-popup">
	<ul>
		@foreach($categories as $category)

			<li>{{Form::checkbox('categories[]', $category->id, false, ['data-label' => $category->cat_name])}} <label>{{$category->cat_name}}</label></li>

		@endforeach
	</ul>

	<br clear="all">

	<a class="btn btn-primary">Close</a>
</div>