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
                            <a class="dropdown-item" href="/stacks/create"><i class="fas fa-folder-plus"></i> Create a Stack</a>
                            <a class="dropdown-item" href="/users/profile"><i class="far fa-user-circle"></i> My Profile</a>
                            <a class="dropdown-item" href="/parking-lot"><i class="fas fa-parking"></i> Parking Lot</a>
                            <a class="dropdown-item notifications" href="/messages-notifications"><i class="fas fa-bell"></i> Messages & Notifications @if ($unread)<span>{{$unread}}</span>@endif</a>
                            

                            @role('admin')

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item">ADMIN</a>

                            <div class="dropdown-divider"></div>


                            <a class="dropdown-item" href="/admin/categories"><i class="fas fa-layer-group"></i> Categories</a>

                            <a class="dropdown-item" href="/admin/media_types"><i class="fas fa-compact-disc"></i> Media Types</a>

                            <a class="dropdown-item" href="/admin/users"><i class="fas fa-users"></i> Users</a>

                            <a class="dropdown-item" href="/admin/roles"><i class="fas fa-user-tag"></i> Roles</a>

                            <a class="dropdown-item" href="/admin/search"><i class="fas fa-search"></i> Search Algorithm</a>

                            <a class="dropdown-item" href="/admin/links/parser"><i class="fas fa-link"></i> Links Parser</a>

                            <a class="dropdown-item" href="/admin/whatsnew"><i class="fas fa-gift"></i> What's New</a>


                            @endrole

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/settings"><i class="fas fa-cog"></i> Settings</a>
                            <a class="dropdown-item" href="/whats-new"><i class="fas fa-gift"></i> What's New</a>

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
@if (Auth::check())
@include('emails.notifications')
@endif
