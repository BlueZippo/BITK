<header>
    <!-- Fixed navbar -->
    <nav class="navbar main_nav navbar-expand-md navbar-light fixed-top bg-light">
        <div class="inner container">



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

            <div class="collapse navbar-collapse" id="navbarCollapse">

                <ul class="navbar-nav">

                    <li class="nav-item {{Request::path() == 'dashboard' ? 'active' : ''}}">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item {{Request::path() == 'stacks/create' ? 'active' : ''}}">
                        <a class="nav-link" href="/stacks/create">Create A Stack</a>
                    </li>

                    <li class="nav-item {{Request::path() == 'stacks/explore' ? 'active' : ''}}">
                        <a class="nav-link" href="/stacks/explore">Explore</a>
                    </li>

                    <li class="nav-item {{Request::path() == 'parking-lot' ? 'active' : ''}}">
                        <a class="nav-link" href="/parking-lot">Parking Lot</a>
                    </li>

                    <li class="nav-item {{Request::path() == 'people' ? 'active' : ''}}">
                        <a class="nav-link" href="/people">People</a>
                    </li>


                </ul>

            </div>

            <div class="float-right">

                @if (Auth::check())

                    <ul class="navbar-nav user-menu">

                        
                        <li class="nav-item notification">
                            <i class="fas fa-bell"></i>
                            @if($unread > 0)
                                <span>{{$unread}}</span> 
                            @endif
                        </li>
                        

                        <li class="nav-item search">

                            @include('layouts.nav.nav-search')

                        </li>

                        <li class="nav-item user-ctrl">

                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">

                                <div class="avatar">

                                    @if (Auth::user()->photo)

                                        <img src="{{Auth::user()->photo}}">

                                    @else

                                        <div class="inner">{{ render_initials( isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email ) }}</div>

                                    @endif
                            
                                </div>

                                
                            </a>

                        </li>


                    </ul>


                @else

                    <ul class="navbar-nav">

                        <li class="nav-item {{Request::path() == 'login' ? 'active' : ''}}">
                            <a class="nav-link float-right" href="/login">Login</a>
                        </li>
                        <li class="nav-item {{Request::path() == 'register' ? 'active' : ''}}">
                            <a class="nav-link" href="/register">Register</a>
                        </li>

                    </ul>

                @endif


            </div>

            
        </div>

    </div><!-- .inner -->
    </nav>

    <nav class="secondary-navbar">

        <div class="container">

            @include('layouts.nav.extras')

            <ul class="float-right navbar-nav">
                <li class="nav-item">
                    <a class="plus nav-link float-right"><i class="fa fa-plus"></i></a>
                    <ul class="navbar-nav sub-navbar">
                        <li class="nav-item">
                            <a   class="add-link nav-link">Create New Link</a>
                        </li>
                        <li class="nav-item">
                            <a href="/stacks/create" class="nav-link">Create New Stack</a>
                        </li>
                        <li class="nav-item">
                            <a  href="/collections/create" class="nav-link">Create New Collection</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>

    </nav>
</header>
@if (Auth::check())
@include('emails.notifications')
@endif
