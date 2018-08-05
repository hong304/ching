<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="content-language" content="en" />
    <title>Ching He Huang Chinese Cooking | @yield('title') | ChingHeHuang.com</title>
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    @yield('header-script')
</head>

<body>

@include('master.navbar')
<div id="app">
@yield('content')
</div>

@if(!Auth::check())
    @include('auth.login-modal')
    @include('auth.register-modal')
    @include('auth.passwords.email')
@endif


@include('master.footer')


<!-- required for vue -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>

<script src="{{ elixir('js/app.js') }}"></script>
<script src="{{ elixir('js/all.js') }}"></script>
<script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit' async defer></script>
<!-- reCAPtcha init -->
<script type="text/javascript">
    var CaptchaCallback = function() {
        grecaptcha.render('RegisterRecaptcha', {'sitekey' : '{{ env('RE_CAP_SITE') }}'});
        {{--grecaptcha.render('SubscriptionRecaptcha', {'sitekey' : '{{ env('RE_CAP_SITE') }}'});--}}
    };
</script>
<script type="text/javascript">

    $(document).ready(function() {
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            setTimeout(function() {
                $('body').css({ 'padding-bottom': $('.bottomMenu').outerHeight(true)+'px'});
                $('.loading-overlay').fadeOut('slow');
                setTimeout(function() {
                    $('.loading-overlay').remove();
                }, 300);
            }, 500);
        } else {
            $('body').css({ 'padding-bottom': $('.bottomMenu').outerHeight(true)+'px'});
            $('.loading-overlay').fadeOut('slow');
            setTimeout(function() {
                $('.loading-overlay').remove();
            }, 300);
        }


        setTimeout(function(){
            // init the global menu
            dropdownBox.css("left", navMenuLink.first().offset().left + (navMenuLink.first().outerWidth(true) / 2) - (dropdownBox.outerWidth() / 2));
            dropdownSection.each(function() {
                minWidthArray.push($(this).outerWidth(true));
            });
        }, 500);


        if (window.location.hash){
            if (window.location.hash=="#_=_"){
                window.location.hash = "";
            }else {
                <?php if(auth()->guest()){?>
                    $(window.location.hash + 'Modal').modal('show');
                <?php }?>
            }
        }
        $("#redirect_url").val(window.location.href);
        $('.collapse-sm-menu-button').click(function() {
            $('.desktop-sm-base-holder').toggleClass("open");
        });

        $(".modal-btn").click(function () {
            var el = $(this).attr("modal-show");
            $(el).modal('show');
        });

        $(".toggle-modals").click(function () {
            $('.modal').modal('hide');
            var modal = $(this).attr('data-toggle-modal');
            setTimeout(function () {
                $(modal).modal('show');
            }, 300);
        });


        // register modal
        $('#gender').select2({minimumResultsForSearch: -1});
        function formatState (state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span class="'+ $(state.element).attr("data-flag")+' flag-position">'+'</span><span>' + state.text + '</span>'
            );
            return $state;
        };
        $('#country').select2({
            templateResult: formatState
        });
        $('.select2').css('width', '100%');

    });


    $(window).resize(function() {
        setTimeout(function() {
            $('body').css({ 'padding-bottom': $('.bottomMenu').outerHeight(true)+'px'});
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

