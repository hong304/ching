<!DOCTYPE html>
<html lang="en">
<head>
    @section('title', 'Ching He Huang | TV Chef, Author & Chinese Cuisine Expert')
    @section('page-description', 'TV chef and cookery author Ching He Huang gives you an all-access pass to her collection of healthy fusion recipes, videos, and amazing culinary adventures.') {{-- Defaults --}}

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="@yield('page-description')">
    <meta http-equiv="content-language" content="en"/>
    <meta property="og:url" content="{{config('app.url')}}/@yield('url')"/>
    <meta property="og:type" content="@yield('page-type')"/>
    <meta property="og:title" content="@yield('title')"/>
    <meta property="og:description" content="@yield('page-description')"/>
    <meta property="og:image" content="@yield('fb-ref-image')"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
    <meta name="msapplication-square70x70logo" content="/smalltile.png"/>
    <meta name="msapplication-square150x150logo" content="/mediumtile.png"/>
    <meta name="msapplication-wide310x150logo" content="/widetile.png"/>
    <meta name="msapplication-square310x310logo" content="/largetile.png"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <script type="text/javascript">
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-26516526-1', 'auto');
        ga('send', 'pageview');
    </script>
    @yield('header-script')
</head>

<body>
<div class="loading-overlay"></div>

@if(isset($continent)&& $continent=='EU')
    @if(!\Illuminate\Support\Facades\Cookie::has('closeCookie'))
        @include('master.message.cookie')
    @endif
@endif

@include('master.footer')

@include('master.navbar')

<div id="app">
    @yield('content')
</div>

@if(!Auth::check())
    @include('master.message.ask-for-register-home')
@endif

<div class="menu-overlay"></div>

<script src="{{ elixir('js/app.js') }}"></script>
<!--compiled from custom.js-->
<script src="{{ elixir('js/all.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            setTimeout(function () {
                $('body').css({'padding-bottom': $('.bottomMenu').outerHeight(true) + 'px'});
                $('.loading-overlay').fadeOut('slow');
                setTimeout(function () {
                    $('.loading-overlay').remove();
                }, 300);
            }, 500);
        } else {
            $('body').css({'padding-bottom': $('.bottomMenu').outerHeight(true) + 'px'});
            $('.loading-overlay').fadeOut('slow');
            setTimeout(function () {
                $('.loading-overlay').remove();
            }, 300);
        }


        setTimeout(function () {
            // init the global menu
            dropdownBox.css("left", navMenuLink.first().offset().left + (navMenuLink.first().outerWidth(true) / 2) - (dropdownBox.outerWidth() / 2));
            dropdownSection.each(function () {
                minWidthArray.push($(this).outerWidth(true));
            });

            if (!Cookies.get('firstVisit')) {
                Cookies.set('firstVisit', true, {expires: 1});

                var page = window.location.href;
                page = page.split('/');

                if (!(page.length > 5 && page[3] == "videos") && !(page.length > 4 && page[3] == "recipes")) {
                    setTimeout(function () {
                        $('#askForRegisterModal').modal('show');
                    }, 2000);
                }
            }

        }, 500);


        if (window.location.hash) {
            if (window.location.hash == "#_=_") {
                window.location.hash = "";
            } else {
                <?php if(auth()->guest()){?>
                    $(window.location.hash + 'Modal').modal('show');
                <?php }?>
            }
        }
        $("#redirect_url").val(window.location.href);
        $('.collapse-sm-menu-button').click(function () {
            $('.desktop-sm-base-holder').toggleClass("open");
        });

        $(".toggle-modals").click(function () {
            $('.modal:visible').modal('hide');
            var modal = $(this).attr('data-toggle-modal');
            if ($(this).attr("id") == "first-login") {
                ga('send', 'event', 'Popup', 'Login', 'First Arrival (per 24 hours)');
            }
            if ($(this).attr("id") == "first-register") {
                ga('send', 'event', 'Popup', 'Registration', 'First Arrival (per 24 hours)');
            }
            setTimeout(function () {
                $(modal).modal('show');
            }, 300);
        });

        // register modal
        $('#gender').select2({minimumResultsForSearch: -1});
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span class="' + $(state.element).attr("data-flag") + ' flag-position">' + '</span><span>' + state.text + '</span>'
            );
            return $state;
        };
        $('#country').select2({
            templateResult: formatState
        });
        $('.select2').css('width', '100%');


        $('.message-close-btn').click(function () {
            $('.message-box').fadeOut("slow");
            $.get("/ajaxCloseCookieAction");
        });

    });

    $(window).resize(function () {
        setTimeout(function () {
            $('body').css({'padding-bottom': $('.bottomMenu').outerHeight(true) + 'px'});
        }, 100);
    })


</script>
@if(!Auth::check())
    <script type="application/javascript">
        $(document).ready(function () {
            $("#country-code").text($('#country').find('option:selected').attr('data-phone'));
            $('#country').change(function () {
                var phone = $(this).find('option:selected').attr('data-phone');
                $("#country-code").text(phone);
            });
        });
    </script>
@endif

@yield('footer-script')

</body>
</html>

