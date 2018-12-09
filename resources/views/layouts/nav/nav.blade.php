<header>
    <!-- Fixed navbar -->
    <nav class="navbar main_nav navbar-expand-md navbar-light fixed-top bg-light">
        <div class="inner container-fluid">

            @if (Auth::check())
                <a class="navbar-brand" href="/dashboard">
            @else
                <a class="navbar-brand" href="/">
            @endif
                {{Html::image('/images/logo-v1.jpg', 'PlatStack')}}
                {{ Html::image('/images/logo-mobile-v1.jpg', 'PlatStack', ['class' => 'mobile']) }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>



            @include('layouts.nav.topics')

            <div class="add-link-wrapper"><div class="add-a-link-button main-nav">Add a Link</div></div>

            @include('layouts.nav.search')

            @include('links.create')


            <div class="mobile-menu-wrapper collapse navbar-collapse" id="navbarCollapse">

                <!-- Mobile User Settings -->

                @include('layouts.nav.mobile-menu')

                <ul class="navbar-nav justify-content-end desktop-user-menu user-menu">

                    @if (Auth::check())

                    

                    <li class="list-divider"></li>
                    <li class="nav-item dropdown user-ctrl">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">



                            <div class="avatar">

                                @if($unread > 0)<span class="notification">{{$unread}}</span> @endif

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
                            <a class="dropdown-item" href="/users/profile">My Profile</a>
                            <a class="dropdown-item" href="/parking-lot">Parking Lot</a>
                            <a class="dropdown-item notifications" href="/messages-notifications">Messages & Notifications @if ($unread)<span>{{$unread}}</span>@endif</a>
                            <a class="dropdown-item" href="/settings">Settings</a>

                            @role('admin')

                            <div class="dropdown-divider"></div>

                                <a class="dropdown-item">ADMIN</a>

                            <div class="dropdown-divider"></div>


                            <a class="dropdown-item" href="/admin/categories">Categories</a>

                            <a class="dropdown-item" href="/admin/media_types">Media Types</a>

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

@include('emails.notifications')
