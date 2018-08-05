<!-- NavBar section -->
<div class="container-fluid p0">
    <nav class="navbar fixed-top global-nav-menu no-dropdown">
        <ul class="nav-box">
            <li class="nav-menu nav-menu-logo"><h1 id="site-header">Ching He Huang</h1><a href="{{ route('index') }}"><img id="logo-dark" src="{{ asset('/images/ching-logo-dark.svg') }}" alt="Ching-He Huang Logo - Dark" /></a></li>
            <li class="nav-menu nav-menu-main">
                <a class="nav-menu-link has-dropdown text-uppercase" data-toggle="recipes">Recipes</a>
                <a class="nav-menu-link has-dropdown text-uppercase" data-toggle="videos">Videos</a>
                <a class="nav-menu-link has-dropdown text-uppercase" data-toggle="blog">Blogs</a>
                <a class="nav-menu-link has-dropdown text-uppercase" data-toggle="shop">Shop</a>
                <a class="nav-menu-link has-dropdown text-uppercase" data-toggle="travel">Travel</a>
                <a class="nav-menu-link has-dropdown text-uppercase" data-toggle="about">About</a>
            </li>

            <li class="nav-menu nav-menu-secondary">
                @if(!Auth::check())
                    {{--<a class="nav-menu-link text-uppercase modal-btn" modal-show="#loginModal"><i class="fa fa-sign-in pr4 disable-inline" aria-hidden="true" ></i> Login</a>--}}
                    {{--<a class="nav-menu-link text-uppercase modal-btn" modal-show="#registerModal"><i class="fa fa-user-plus pr4 disable-inline" aria-hidden="true" ></i> Register</a>--}}
                    <a href="{{ route('login') }}" class="nav-menu-link text-uppercase"><i class="fa fa-sign-in pr4 disable-inline" aria-hidden="true" ></i> Login</a>
                    <a href="{{ route('register') }}" class="nav-menu-link text-uppercase"><i class="fa fa-user-plus pr4 disable-inline" aria-hidden="true" ></i> Register</a>
                @else
                    <a class="nav-menu-link has-dropdown text-uppercase" data-toggle="usersetting">
                        <span class="profile-avatar">
                            @if (isset(Auth::user()->avatar))
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" >
                            @elseif (isset(Auth::user()->facebook_id))
                                <img src="https://graph.facebook.com/{{ Auth::user()->facebook_id }}/picture?width=30&height=30" >
                            @else
                                <img src="/images/avatar-img.svg" >
                            @endif
                        </span>
                        {{ Auth::user()->first_name ." ". Auth::user()->last_name }}
                    </a>
                @endif
            </li>
            <li class="nav-menu nav-menu-mobile">
                @include('master.mobile-nav')
            </li>
        </ul>
        <div class="dropdown-box">
            <div class="dropdown-container">
                <!-- recipes section -->
                <div class="dropdown-section" data-toggle="recipes">
                    <div class="dropdown-content two-tabs">
                        <ul class="link-group">
                            <li class="main-menu-link"><a href="{{ route('recipe') }}" class="header-link" id="icon-all-recipes">All Recipes</a></li>
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['all','chicken']) }}" id="icon-chicken">Chicken</a></li>
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['all','pork']) }}" id="icon-pork">Pork</a></li>
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['all','vegetarian']) }}" id="icon-vegetarian">Vegetarian</a></li>
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['all','seafood']) }}" id="icon-seafood">Seafood</a></li>
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['all','salad']) }}" id="icon-salad">Salad</a></li>
                        </ul>
                        <ul class="link-group">
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['main-courses']) }}" id="icon-main-course">Main course</a></li>
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['snacks-and-sides']) }}" id="icon-snacks-sides">Snacks & Sides</a></li>
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['starter']) }}" id="icon-starter">Starter</a></li>
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['dessert']) }}" id="icon-dessert">Dessert</a></li>
                            <li class="main-menu-link"><a href="{{ route('recipe-search',['soup']) }}" id="icon-soup">Soup</a></li>
                        </ul>
                    </div>
                </div>

                <!-- videos section -->
                <div class="dropdown-section" data-toggle="videos">
                    <div class="dropdown-content">
                        <ul class="link-group">
                            <li class="main-menu-link"><a href="{{ route('all-video') }}" class="header-link" id="icon-all-videos">All Videos</a></li>
                            <li class="main-menu-link"><a href="{{ route('video-series', 'flavology') }}" id="icon-flavology">Flavology <span class="new-label">New</span></a></li>
                            <li class="main-menu-link"><a href="{{ route('video-series', 'click-and-cook') }}" id="icon-click-cook">Click & Cook</a></li>
                            <li class="main-menu-link"><a href="{{ route('video-series', 'hot-off-the-wok') }}" id="icon-hotw">Hot Off The Wok</a></li>
                            <li class="main-menu-link"><a href="{{ route('video-series', 'lee-kum-kee-shorts') }}" id="icon-lkk">Lee Kum Kee</a></li>
                        </ul>
                    </div>
                </div>

                <!-- blog section -->
                <div class="dropdown-section" data-toggle="blog">
                    <div class="dropdown-content">
                        <ul class="link-group">
                            <li class="main-menu-link"><a href="{{ route('blog') }}" class="header-link" id="icon-all-blogs">All Blogs</a></li>
                            <li class="main-menu-link"><a href="{{ route('blog', 'Food') }}" id="icon-food">Food</a></li>
                            <li class="main-menu-link"><a href="{{ route('blog', 'Inspiration') }}" id="icon-inspiration">Inspiration</a></li>
                            <li class="main-menu-link"><a href="{{ route('blog', 'News') }}" id="icon-news">News</a></li>
                            <li class="main-menu-link"><a href="{{ route('blog', 'Charity') }}" id="icon-charity">Charity</a></li>
                        </ul>
                    </div>
                </div>

                <!-- buy section -->
                <div class="dropdown-section" data-toggle="shop">
                    <div class="dropdown-content">
                        <ul class="link-group">
                            <li class="main-menu-link"><a href="{{ route('lotus-wok') }}" id="icon-lotus-wok">Lotus Wok</a></li>
                            <li class="main-menu-link"><a href="{{ route('books') }}" id="icon-books">Books</a></li>
                        </ul>
                    </div>
                </div>

                <!-- travel section -->
                <div class="dropdown-section" data-toggle="travel">
                    <div class="dropdown-content">
                        <ul class="link-group">
                            <li class="main-menu-link"><a href="{{ route('amazing-asia') }}" id="icon-amazingasia">Amazing Asia</a></li>
                        </ul>
                    </div>
                </div>

                <!-- about ching section -->
                <div class="dropdown-section" data-toggle="about">
                    <div class="dropdown-content">
                        <ul class="link-group">
                            <li class="main-menu-link"><a href="{{ route('biography') }}" id="icon-biography">Biography</a></li>
                            <li class="main-menu-link"><a href="{{ route('my-story') }}" id="icon-my-story">My Story</a></li>
                        </ul>
                    </div>
                </div>

                @if(Auth::check())
                    <!-- user setting dropdown -->
                    <div class="dropdown-section" data-toggle="usersetting">
                        <div class="dropdown-content">
                            <ul class="link-group">
                                @if(Auth::user()->admin)
                                    <li class="user-menu-link"><a href="{{ route('admin') }}"><i class="fa fa-key disable-inline" aria-hidden="true"></i> Admin</a></li>
                                @endif
                                <li class="user-menu-link"><a href="{{ route('profile') }}"><i class="fa fa-cog disable-inline" aria-hidden="true"></i> Setting</a></li>
                                <li class="user-menu-link"><a href="{{ route('logout') }}" ><i class="fa fa-sign-out disable-inline" aria-hidden="true"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</div>


