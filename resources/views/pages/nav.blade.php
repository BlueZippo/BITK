<ul class="nav nav-pills transition">

	<li class="nav-item">
        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">Dashboard</a>
	</li>
	<li class="nav-item">
        <a class="nav-link {{ request()->is('stacks/create') ? 'active' : '' }}" href="/stacks/create">Create a Stack</a>
	</li>
	<li class="nav-item">
        <a class="nav-link {{ request()->is('stacks/explore') ? 'active' : '' }}" href="/stacks/explore">Explore</a>
	</li>
	<li class="nav-item">
        <a class="nav-link {{ request()->is('parking-lot') ? 'active' : '' }}" href="/parking-lot/">Parking Lot</a>
	</li>
	<li class="nav-item">
        <a class="nav-link {{ request()->is('users/profile') ? 'active' : '' }}" href="/users/profile">Profile</a>
	</li>
	<!--<li class="nav-item">
        <a class="nav-link" href="/skills-and-topics">Skills & Topics</a>
	</li>-->
	<li class="nav-item">
        <a class="nav-link {{ request()->is('people') ? 'active' : '' }}" href="/people/">People</a>
	</li>
	<li class="nav-item">
        <a class="nav-link {{ request()->is('tags') ? 'active' : '' }}" href="/tags/">Tags</a>
	</li>
</ul>
