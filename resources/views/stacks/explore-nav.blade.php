<label class="view-button">View: 
	<a class="tile"><i class="fa fa-th-large"></i></a>  
	<a class="compact"><i class="fa fa-th"></i></a> 
	<a class="list"><i class="fa fa-bars"></i></a>
</label>

<label class="sort-button"><span>Sort:</span> 
	{{Form::select('sort', $navSort, $sort, ['class' => 'chosen'])}}
</label>