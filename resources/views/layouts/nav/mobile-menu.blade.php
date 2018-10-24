<div class="mobile-nav">
    @include('layouts.nav.search')
    <ul class="menu">
        <li class="topics with-menu">
            <a href="#">Topics</a>
            <div class="sub-menu">
                <div class="inner">
                    @foreach(App\Category::orderby('cat_name')->get() as $category)
                        <a class="sub-menu-item" href="/stacks/{{$category->id}}/category">{{$category->cat_name}}</a>
                    @endforeach
                </div>
            </div>
        </li>

  		<li><a href="/stacks/explore">Explore</a></li>
  		<li><a href="/skills-and-topics">Skills & Topics</a></li>
  		<li><a href="/people/">People</a></li>
  		<li><a class="nav-link" href="/tags/">Tags</a></li>

        @if (Auth::check())

        <li class="user with-menu">
            <a href="#">

                <div class="avatar">
                    @if (Auth::user()->photo)

                    <img src="{{Auth::user()->photo}}">

                    @else

                    <div class="inner">{{ render_initials( isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email ) }}</div>

                    @endif
                </div>

                <div class="name">{{ Auth::user()->name }}</div>
            </a>
            <div class="sub-menu">
                <div class="inner">
                    <a class="sub-menu-item" href="/stacks/create">Create a Stack</a>
                    <a class="sub-menu-item" href="/users/profile">My Profile</a>
                    <a class="sub-menu-item" href="/parking-lot/">Parking Lot</a>

                    @role('admin')

                    <div class="dropdown-divider"></div>

                        <a class="sub-menu-item">ADMIN</a>

                    <div class="dropdown-divider"></div>

                    <a class="sub-menu-item" href="/admin/categories">Media Type</a>

                    <a class="sub-menu-item" href="/admin/users">Users</a>

                    <a class="sub-menu-item" href="/admin/roles">Roles</a>

                    <a class="sub-menu-item" href="/admin/search">Search Algorithm</a>

                    @endrole

                    <div class="dropdown-divider"></div>
                    <a class="sub-menu-item" href="/logout">Logout</a>
                </div>
            </div>
        </li>

        @else

        <li class="list-divider"></li>
        <li><a href="/login">Login</a></li>
        <li><a href="/register">Register</a></li>

        @endif

    </ul>
</div>
