@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | Profile | ChingHeHuang.com')
@section('header-script')
    <link rel="Stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.0/croppie.css">
    <link rel="Stylesheet" type="text/css" href="/plugins/jquery-ui-datepicker/jquery-ui.min.css">
@endsection



@section('content')

    <section class="offset-top bg-color almost-white blank-page-margin">
        <div class="container">
            <div class="row">
                <div class="col-md-3 text-left">
                    @include('front.user.include.side-nav')
                </div>
                <div class="col-md-9 text-left">

                @include('front.user.include.setting.message')

                <!-- Tab box -->
                    <div class="profile-tab-box">
                        <div class="tab-content">


                            <!-- the intro tab -->
                            <div role="tabpanel" class="tab-content-holder tab-pane fade" id="personalinformation">
                                @include('front.user.include.setting.personal-information')
                            </div>

                            <!-- change password tab -->
                            <div role="tabpanel" class="tab-content-holder tab-pane fade" id="changepassword">
                                @include('front.user.include.setting.change-password')
                            </div>

                            <!-- change email -->
                            <div role="tabpanel" class="tab-content-holder tab-pane fade" id="changeemail">
                                @include('front.user.include.setting.change-email')
                            </div>

                            <!-- change email -->
                            <div role="tabpanel" class="tab-content-holder tab-pane fade" id="subscriptionsetting">
                                @include('front.user.include.setting.subscription-setting')
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>


@endsection

@section('footer-script')
    <script src="{{ elixir('js/croppie.js') }}"></script>
    <script src="/plugins/jquery-ui-datepicker/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var basic;
        var page = @if(Session::has('page')) "{{ Session::get('page') }}" @else "personalinformation" @endif;
        $(document).ready(function () {

            $('#'+page).addClass('active show');
            $('#nav-'+page).addClass('active');

            function formatState (state) {
                if (!state.id) { return state.text; }
                var $state = $(
                    '<span class="'+ $(state.element).attr("data-flag")+' flag-position">'+'</span><span>' + state.text + '</span>'
                );
                return $state;
            };

            $('#subscription').select2({minimumResultsForSearch: -1});
            $('#country').select2({
                templateResult: formatState
            });
            $("#country-code").text($('#country').find('option:selected').attr('data-phone'));
            $('#country').change(function () {
                var phone = $(this).find('option:selected').attr('data-phone');
                $("#country-code").text(phone);
            });
            var boundaryH = 460;
            if ($(window).width() < 768 ){
                boundaryH = 300;
            }
            basic = $('#cropper').croppie({
                viewport: {
                    width: 280,
                    height: 280,
                    type: 'square'
                },
                boundary: {
                    width: 460,
                    height: boundaryH
                },
            });
            $(".cr-slider").attr('min', '0.2');
            $(".cr-slider").attr('max', '1.5');

            $('#avatar_file').change(function () {
                if (iphone() && this.files[0].size > 1024000){
                    alert('iPhone limited the maximum upload size to 1MB.');
                    this.value = '';
                    return false;
                }else if(this.files[0].size > 5120000){
                    alert('Please upload image with size less than 5MB.');
                    this.value = '';
                    return false;
                }
                var ext = this.value.match(/\.(.+)$/)[1];
                switch (ext.toLowerCase()) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        $("#avatar_modal").modal('show');
                        readURL(this);
                        break;
                    default:
                        alert('This is not an allowed file type.');
                        this.value = '';
                }
            });
            $('#save-avatar').click(function () {
                basic.croppie('result', {
                    type : 'base64',
                    format: 'jpeg',
                }).then(function (resp) {
                    $("#avatar_cropped").val(resp);
                    $("#avatar_form").submit();
                });
            });


            $( "#birthday" ).datepicker({
                dateFormat: "yy-mm-dd"
            });

        });
        $(window).resize(function(){
            setTimeout(function(){
                $('.select2').width('100%');
            }, 300);
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    basic.croppie('bind', {
                        url: e.target.result,
                        points: [0, 0, 0, 0],
                        zoom: 1,
                    }).then(function () {
                        $(".cr-image, .cr-overlay").css('transform','none');
                        $(".cr-slider").val('1');
                    });
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        function iphone() {
            var iDevices = [
                'iPhone',
                'iPod',
            ];
            if (!!navigator.platform) {
                while (iDevices.length) {
                    if (navigator.platform === iDevices.pop()){
                        return true;
                    }
                }
            }
            return false;
        }

        // clear the message when changing the tab
        $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
            $('.alert').hide();
        });


        $('#country').on('select2:opening', function() {
            $('.global-nav-menu').css('z-index', 1052);
        }).on('select2:close', function() {
            $('.global-nav-menu').removeAttr('style');
        });


    </script>
@endsection