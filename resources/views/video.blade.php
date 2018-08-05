<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="content-language" content="en" />
    <title>Ching He Huang Chinese Cooking | @yield('title') | ChingHeHuang.com</title>

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    @yield('header-script')
</head>

<body class="full-height p0 bg-color black">
<div class="loading-overlay"></div>


@yield('content')



<script src="{{ elixir('js/app.js') }}"></script>
<script src="{{ elixir('js/all.js') }}"></script>
@yield('footer-script')
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {
            $('.loading-overlay').fadeOut('slow');
            setTimeout(function() {
                $('.loading-overlay').remove();
            }, 300);
        }, 500);
    });
</script>
</body>
</html>

