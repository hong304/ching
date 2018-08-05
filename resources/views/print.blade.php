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
<div class="loading-overlay"></div>

<section>
    <div class="container-fluid">
        <div class="row standard-padding">
            <div class="col-3 mt16 mb16 text-left">
                <div class="logo-brand">
                    <img id="logo-dark" src="{{ asset('/images/ching-logo-dark.svg') }}" alt="Ching-He Huang Logo - Dark" />
                </div>
            </div>
            <div class="col-9 text-right mt40">
                <p class="small-90 mb0 text-color main">Recipe from www.chinghehuang.com</p>
            </div>
        </div>
    </div>
</section>
@yield('content')




<script src="{{ elixir('js/app.js') }}"></script>
<script src="{{ elixir('js/all.js') }}"></script>
@yield('footer-script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.loading-overlay').fadeOut('slow');
        setTimeout(function() {
            $('.loading-overlay').remove();
        }, 300);
        setTimeout(function() {
            window.print();
        }, 1000);
    });
</script>
</body>
</html>