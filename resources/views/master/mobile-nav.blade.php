<a class="mobile-popup-link"><i class="fa fa-bars" aria-hidden="true"></i></a>
<div class="mobile-popup">
    <div class="mobile-container">
        <a class="popup-close-btn"><i class="fa fa-times" aria-hidden="true"></i></a>
        <div class="mobile-main">
            <div class="mobile-menu-cate">Browse</div>
            <ul class="link-group">

                <!-- Mobile menu :: recipe section -->
                <li class="mobile-menu-link">
                    <a class="mobile-collapse-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseRecipes" aria-expanded="false" aria-controls="collapseRecipes">
                        <div class="mobile-collapse-title">
                            <span>Recipes</span> <i class="fa fa-angle-down" aria-hidden="true"></i><i class="fa fa-angle-up" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div id="collapseRecipes" class="collapse" role="tabpanel" aria-labelledby="caption">
                        <ul class="mobile-menu-collapse" id="recipes">
                            <li class="two-tabs">
                                <ul>
                                    <li class="mobile-menu-item"><a href="{{route('recipe')}}" class="header-link" id="micon-all-recipes">All Recipes</a></li>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['all','chicken']) }}" id="micon-chicken">Chicken</a></li>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['all','pork']) }}" id="micon-pork">Pork</a></li>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['all','vegetarian']) }}" id="micon-vegetarian">Vegetarian</a></li>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['all','seafood']) }}" id="micon-seafood">Seafood</a></li>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['all','salad']) }}" id="micon-salad">Salad</a></li>
                                </ul>
                            </li>
                            <li class="two-tabs">
                                <ul>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['main-courses']) }}" id="micon-main-course">Main course</a></li>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['snacks-and-sides']) }}" id="micon-snacks-sides">Snacks & Sides</a></li>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['starter']) }}" id="micon-starter">Starter</a></li>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['dessert']) }}" id="micon-dessert">Dessert</a></li>
                                    <li class="mobile-menu-item"><a href="{{ route('recipe-search',['soup']) }}" id="micon-soup">Soup</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="clear-float"></div>
                    </div>
                </li>

                <!-- Mobile menu :: video section -->
                <li class="mobile-menu-link">
                    <a class="mobile-collapse-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseVideos" aria-expanded="false" aria-controls="collapseVideos">
                        <div class="mobile-collapse-title">
                            <span>Videos</span> <i class="fa fa-angle-down" aria-hidden="true"></i><i class="fa fa-angle-up" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div id="collapseVideos" class="collapse" role="tabpanel" aria-labelledby="caption">
                        <ul class="mobile-menu-collapse" id="videos">
                            <li class="mobile-menu-item"><a href="{{ route('all-video') }}" class="header-link" id="micon-all-videos">All Videos</a></li>
                            <li class="mobile-menu-item"><a href="{{ route('video-series', 'flavology') }}" id="micon-flavology">Flavology <span class="new-label">New</span></a></li>
                            <li class="mobile-menu-item"><a href="{{ route('video-series', 'click-and-cook') }}" id="micon-click-cook">Click & Cook</a></li>
                            <li class="mobile-menu-item"><a href="{{ route('video-series', 'hot-off-the-wok') }}" id="micon-hotw">Hot Off The Wok</a></li>
                            <li class="mobile-menu-item"><a href="{{ route('video-series', 'lee-kum-kee-shorts') }}" id="micon-lkk">Lee Kum Kee</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Mobile menu :: blog section -->
                <li class="mobile-menu-link">
                    <a class="mobile-collapse-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseBlogs" aria-expanded="false" aria-controls="collapseBlogs">
                        <div class="mobile-collapse-title">
                            <span>Blogs</span> <i class="fa fa-angle-down" aria-hidden="true"></i><i class="fa fa-angle-up" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div id="collapseBlogs" class="collapse" role="tabpanel" aria-labelledby="caption">
                        <ul class="mobile-menu-collapse" id="blogs">
                            <li class="mobile-menu-item"><a href="{{ route('blog') }}" class="header-link" id="micon-all-blogs">All Blogs</a></li>
                            <li class="mobile-menu-item"><a href="{{ route('blog', 'Food' )}}" id="micon-food">Food</a></li>
                            <li class="mobile-menu-item"><a href="{{ route('blog', 'Inspiration' )}}" id="micon-inspiration">Inspiration</a></li>
                            <li class="mobile-menu-item"><a href="{{ route('blog', 'News' )}}" id="micon-news">News</a></li>
                            <li class="mobile-menu-item"><a href="{{ route('blog', 'Charity' )}}" id="micon-charity">Charity</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Mobile menu :: shop section -->
                <li class="mobile-menu-link">
                    <a class="mobile-collapse-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseShop" aria-expanded="false" aria-controls="collapseShop">
                        <div class="mobile-collapse-title">
                            <span>Shop</span> <i class="fa fa-angle-down" aria-hidden="true"></i><i class="fa fa-angle-up" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div id="collapseShop" class="collapse" role="tabpanel" aria-labelledby="caption">
                        <ul class="mobile-menu-collapse" id="shop">
                            <li class="mobile-menu-item"><a href="{{ route('lotus-wok') }}" id="micon-lotus-wok">Lotus Wok</a></li>
                            <li class="mobile-menu-item"><a href="{{ route('books') }}" id="micon-books">Books</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Mobile menu :: travel section -->
                <li class="mobile-menu-link">
                    <a class="mobile-collapse-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTravel" aria-expanded="false" aria-controls="collapseTravel">
                        <div class="mobile-collapse-title">
                            <span>Travel</span> <i class="fa fa-angle-down" aria-hidden="true"></i><i class="fa fa-angle-up" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div id="collapseTravel" class="collapse" role="tabpanel" aria-labelledby="caption">
                        <ul class="mobile-menu-collapse" id="travel">
                            <li class="mobile-menu-item"><a href="{{ route('amazing-asia') }}" id="micon-amazingasia">Amazing Asia</a></li>
                        </ul>
                    </div>
                </li>


                <!-- Mobile menu :: about section -->
                <li class="mobile-menu-link">
                    <a class="mobile-collapse-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseAbout" aria-expanded="false" aria-controls="collapseAbout">
                        <div class="mobile-collapse-title">
                            <span>About</span> <i class="fa fa-angle-down" aria-hidden="true"></i><i class="fa fa-angle-up" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div id="collapseAbout" class="collapse" role="tabpanel" aria-labelledby="caption">
                        <ul class="mobile-menu-collapse" id="travel">
                            <li class="mobile-menu-item"><a href="{{ route('biography') }}" id="micon-biography">Biography</a></li>
                            <li class="mobile-menu-item"><a href="{{ route('my-story') }}" id="micon-my-story">My Story</a></li>
                        </ul>
                    </div>
                </li>

            </ul>
            <div class="clear-float"></div>
        </div>
        <div class="mobile-secondary">
            <div class="mobile-menu-cate">User</div>
            <ul class="link-group">
                @if(!Auth::check())
                    <li class="mobile-menu-link without-collapse two-tabs"><a href="{{ route('login') }}" class="mobile-menu-link text-uppercase modal-btn"><i class="fa fa-sign-in pr4 disable-inline" aria-hidden="true" ></i> Login</a></li>
                    <li class="mobile-menu-link without-collapse two-tabs"><a href="{{ route('register') }}" class="mobile-menu-link text-uppercase modal-btn"><i class="fa fa-user-plus pr4 disable-inline" aria-hidden="true" ></i> Register</a></li>
                    <div class="clear-float"></div>
                @else
                    <li class="mobile-avatar-holder">
                        <span class="profile-avatar">
                            @if (isset(Auth::user()->avatar))
                                <img src="{{storage::url(Auth::user()->avatar)}}" >
                            @elseif (isset(Auth::user()->facebook_id))
                                <img src="https://graph.facebook.com/{{ Auth::user()->facebook_id }}/picture?width=30&height=30" >
                            @else
                                <img src="/images/avatar-img.svg" >
                            @endif
                        </span>
                        {{Auth::user()->first_name ." ". Auth::user()->last_name}}
                    </li>
                    @if(Auth::check() && Auth::user()->admin)
                        <li class="mobile-menu-link without-collapse two-tabs"><a href="{{route('admin')}}"><i class="fa fa-key mobile-user-menu-link disable-inline" aria-hidden="true"></i> Admin</a>
                    @endif
                    <li class="mobile-menu-link without-collapse two-tabs"><a href="{{route('profile')}}"><i class="fa fa-cog mobile-user-menu-link disable-inline" aria-hidden="true"></i> Setting</a>
                    <li class="mobile-menu-link without-collapse two-tabs"><a href="{{route('logout')}}" ><i class="fa fa-sign-out mobile-user-menu-link disable-inline" aria-hidden="true"></i> Logout</a></li>
                    <div class="clear-float"></div>
                @endif
            </ul>
        </div>
    </div>
</div>