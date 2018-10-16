<<<<<<< HEAD
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="/">SITE LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>

                @role('admin')
                <li class="nav-item">
                    <a class="nav-link" href="/categories">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/roles">Roles</a>
                </li>
                @endrole
            </ul>

            @if (Auth::check())

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/stacks/create">Create a Stack</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </li>
            </ul>

            @else

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>
            </ul>            

            @endif

        </div>
    </nav>
</header>
=======
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
                    <a class="nav-link" href="/categories">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/roles">Roles</a>
                </li>

                @endrole

                @if (Auth::check())

                <li class="list-divider"></li>
                <li class="nav-item dropdown user-ctrl">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar"><div class="inner">{{ render_initials( isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email ) }}</div></div>
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
>>>>>>> a298193d466df19cca21e11c3575073676d3e7c0
