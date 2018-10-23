<header>
    <!-- Fixed navbar -->
    <nav class="navbar main_nav navbar-expand-md navbar-light fixed-top bg-light">
        <div class="inner container">

            <a class="navbar-brand" href="/">{{Html::image('/images/logo-v1.jpg')}}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @include('layouts.nav.topics')

            @include('layouts.nav.search')


            <div class="user-wrapper collapse navbar-collapse" id="navbarCollapse">

                <!-- Mobile User Settings -->
                <div class="search-mobile">@include('layouts.nav.search')</div>

                <div class="topics-mobile">@include('layouts.nav.topics')</div>

                <ul class="navbar-nav mr-auto justify-content-end user-menu">

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

                            @role('admin')

                            <div class="dropdown-divider"></div>

                                <a class="dropdown-item">ADMIN</a>

                            <div class="dropdown-divider"></div>


                            <a class="dropdown-item" href="/admin/categories">Media Type</a>

                            <a class="dropdown-item" href="/admin/users">Users</a>

                            <a class="dropdown-item" href="/admin/roles">Roles</a>

                            <a class="dropdown-item" href="/admin/search">Search Algorithm</a>


                            @endrole

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
