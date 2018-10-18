<header>
    <!-- Fixed navbar -->
    <nav class="navbar main_nav navbar-expand-md navbar-light fixed-top bg-light">
        <div class="inner container">
        <a class="navbar-brand" href="/">SITE LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            @if (Auth::check())
            <div class="user-ctrl-mobile">
                <div class="avatar user-col-1"><div class="inner">{{ render_initials( isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email ) }}</div></div>
                <div class="user-col-2">
                    <div class="name"><p>{{ Auth::user()->name }}</p></div>
                    <div class="links">
                        <a class="" href="/stacks/create">Create a Stack</a>
                        <a class="" href="/users/profile">User Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="" href="/logout">Logout</a>
                    </div>
                </div>
            </div>
            @endif
            <ul class="navbar-nav mr-auto justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>

                @role('admin')

                <li class="nav-item">
                    <a class="nav-link" href="/admin/categories">Media Type</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/users">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/roles">Roles</a>
                </li>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/search">Search Algorithm</a>
                </li>

                @endrole

                @if (Auth::check())

                <li class="list-divider"></li>
                <li class="nav-item dropdown user-ctrl">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        
                        <div class="avatar">
                            @if (Auth::user()->photo)    

                            <img src="{{Auth::user()->photo}}">
                            
                            @else

                            <div class="inner">{{ render_initials( isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email ) }}</div>

                            @endif
                        </div>

                        <div class="name">{{ Auth::user()->name }}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/stacks/create">Create a Stack</a>
                        <a class="dropdown-item" href="/users/profile">User Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </li>

                @else

                <li class="list-divider"></li>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>

                @endif

            </ul>

        </div>
    </div><!-- .inner -->
    </nav>
</header>

