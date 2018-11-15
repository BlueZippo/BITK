<ul class="nav nav-pills transition">

	{{--@if (!Request::is('dashboard'))--}}
	<li class="nav-item">
        <a class="nav-link" href="/dashboard">Dashboard</a>
	</li>
	{{--@endif--}}
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
	<!--<li class="nav-item">
        <a class="nav-link" href="/skills-and-topics">Skills & Topics</a>
	</li>-->
	<li class="nav-item">
        <a class="nav-link" href="/people/">People</a>
	</li>
	<li class="nav-item">
        <a class="nav-link" href="/tags/">Tags</a>
	</li>
</ul>
