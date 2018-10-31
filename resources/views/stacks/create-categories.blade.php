<div class="categories-popup">
	<ul>
		@foreach($categories as $category)

			<li>

				@if (in_array($category->id, $stack_category_ids))
				{{Form::checkbox('categories[]', $category->id, true , ['data-label' => $category->cat_name])}} 
				@else
				{{Form::checkbox('categories[]', $category->id, false , ['data-label' => $category->cat_name])}} 
				@endif

				<label>{{$category->cat_name}}</label>
			</li>

		@endforeach
	</ul>

	<br clear="all">

	<a class="btn btn-primary">Close</a>
</div>