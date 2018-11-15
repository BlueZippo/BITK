<div class="explorer-nav">

	<label class="view-button">View:
		<a class="tile"><i class="fa fa-th-large"></i></a>
		<a class="compact"><i class="fa fa-th"></i></a>
		<a class="list"><i class="fa fa-bars"></i></a>
	</label>

	<label class="sort-button"><span>Sort:</span>
		{{Form::select('sort', $navSort, $sort, ['class' => 'chosen'])}}
	</label>

	<ul class="nav nav-pills transition">

		<li class="nav-item">
	        <a class="nav-link" href="/dashboard">Dashboard</a>
		</li>

		<li class="nav-item">
	        <a class="nav-link" href="/stacks/create">Create a Stack</a>
		</li>

		<li class="nav-item">
	        <a class="nav-link" href="/stacks/explore">Explore</a>
		</li>

		<li class="nav-item">
	        <a class="nav-link" href="/parking-lot/">Parking Lot</a>
		</li>

		<li class="nav-item">
	        <a class="nav-link" href="/users/profile">Profile</a>
		</li>

		<li class="nav-item">
	        <a class="nav-link" href="/people/">People</a>
		</li>
		<li class="nav-item">
	        <a class="nav-link" href="/tags/">Tags</a>
		</li>

	</ul>

</div>
