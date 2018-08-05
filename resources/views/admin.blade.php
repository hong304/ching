<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="content-language" content="en"/>
    <title>Ching He Huang Chinese Cooking | @yield('title') | ChingHeHuang.com</title>
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/admin.css') }}">
    @yield('header-script')
</head>

<body>
<div class="loading-overlay"></div>

<div class="container-fluid admin" id="app">
    <div class="row no-gutters">
        <div id="sidebar">
            <div class="sidebar-header">
                <a class="" href="{{route('index')}}">
                    <img id="logo" src="/images/ching-logo-light.svg" alt="Ching-He Huang Logo - Light">
                </a>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li><a href="{{route('admin')}}"
                           @if(strcmp(Route::currentRouteName(), 'admin') == 0) class="router-link-active" @endif>Dashboard</a>
                    </li>
                    <li><a href="{{route('adminBlog.index')}}"
                           @if(strpos(Route::currentRouteName(), 'adminBlog') !== false) class="router-link-active" @endif>Blog</a>
                    </li>
                    <li>
                        <a href="{{route('adminImage.index')}}"
                           @if(strpos(Route::currentRouteName(), 'adminImage') !== false) class="router-link-active" @endif>Images</a>
                        {{--<a class="mobile-collapse-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseImages" aria-expanded="false" aria-controls="collapseImages">
                            Images
                        </a>
                        <ul id="collapseImages" class="collapse" role="tabpanel" aria-labelledby="caption">
                            <li><a href="#" @if(strpos(Route::currentRouteName(), 'adminImage') !== false) class="router-link-active" @endif>123</a></li>
                            <li><a href="#">123</a></li>
                            <li><a href="#">123</a></li>
                            <li><a href="#">123</a></li>
                            <li><a href="#">123</a></li>
                        </ul>--}}
                    </li>
                    <li><a href="{{route('adminRecipes.index')}}"
                           @if(strpos(Route::currentRouteName(), 'adminRecipes') !== false) class="router-link-active" @endif>Recipes</a>
                    </li>
                    <li><a href="{{route('adminRecipeIngredientSection.index')}}"
                                                 @if(strpos(Route::currentRouteName(), 'adminRecipeIngredientSection') !== false) class="router-link-active" @endif>Recipes
                            Ingredient Sections</a>
                    </li>
                    <li><a href="{{route('adminIngredients.index')}}"
                           @if(strpos(Route::currentRouteName(), 'adminIngredients') !== false) class="router-link-active" @endif>Ingredients</a>
                    </li>
                    <li><a href="{{route('adminIngredientType.index')}}"
                           @if(strpos(Route::currentRouteName(), 'adminIngredientType') !== false) class="router-link-active" @endif>Ingredient Types</a>
                    </li>
                    <li><a href="{{route('adminUser.index')}}"
                           @if(strpos(Route::currentRouteName(), 'adminUser') !== false) class="router-link-active" @endif>Users</a>
                    </li>
                    {{--<li><a href="{{route('adminEdm.index')}}"--}}
                           {{--@if(strpos(Route::currentRouteName(), 'adminEdm') !== false) class="router-link-active" @endif>Regular EDM</a>--}}
                    {{--</li>--}}
                    <li><a href="{{route('adminNewsletter.index')}}"
                           @if(strpos(Route::currentRouteName(), 'adminNewsletter') !== false) class="router-link-active" @endif>Newsletter</a>
                    </li>
                    {{--<li><a href="{{route('admin-videos')}}" @if(Route::currentRouteName() == 'admin-videos')class="router-link-active" @endif>Videos</a></li>--}}
                </ul>
            </div>
        </div>
        <div id="dashboard">
            <nav class="navbar admin-nav-menu">
                <ul class="nav-box">
                    <li class="nav-menu nav-menu-secondary">
                        <div class="menu-profile-section">
                            <span class="profile-avatar">
                                @if (isset(Auth::user()->avatar))
                                    <img src="{{Storage::url(Auth::user()->avatar)}}">
                                @elseif (isset(Auth::user()->facebook_id))
                                    <img src="https://graph.facebook.com/{{ Auth::user()->facebook_id }}/picture?width=30&height=30">
                                @else
                                    <img src="/images/avatar-img.svg">
                                @endif
                            </span>
                            <div class="profile-user-name">{{Auth::user()->first_name ." ". Auth::user()->last_name}}</div>
                        </div>
                        <a class="nav-menu-link text-uppercase" href="{{route('profile')}}"><i
                                    class="fa fa-cog pr8 disable-inline" aria-hidden="true"></i> Setting</a>
                        <a class="nav-menu-link text-uppercase" href="{{route('logout')}}"><i
                                    class="fa fa-sign-out pr8 disable-inline" aria-hidden="true"></i> Logout</a>
                    </li>
                </ul>
            </nav>
            <div class="admin-panel">
                @yield('content')
            </div>
        </div>
    </div>

</div>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
<script src="{{ elixir('js/app.js') }}"></script>
<script src="{{ elixir('js/all.js') }}"></script>
@yield('footer-script')
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            $('.loading-overlay').fadeOut('slow');
            setTimeout(function () {
                $('.loading-overlay').remove();
            }, 300);
        }, 500);
    });
</script>
</body>
</html>

