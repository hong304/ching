@extends('blank')

@section('title', 'Reset password')

@section('header-script')

@endsection



@section('content')

    <section class="blank-page image-backgronud">
        <div class="container-fluid register-panel-position">
            <div class="row">
                <div class="col-xl-6 col-lg-8 col-md-10 offset-xl-3 offset-lg-2 offset-md-1">
                    <div class="text-center login-section dark-shadow" id="ask-for-information">
                        <img class="title-logo vectical-logo" id="logo-dark" src="/images/ching-vlogo-dark.svg"  alt="Ching He Huang Logo - Dark"/>
                        <h2 class="text-uppercase mt40">Oops!</h2>
                        <p class="small-90 mb40">It seems your Facebook account doesn’t include an email address. Please fill it out below to complete registration, thank you!</p>

                        @if (session('status')=="success")
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('complete_facebook_sign_up') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="email" class="form-control @if($errors->has('email')) alert-danger @endif" id="loginEmail" placeholder="Email address" name="email" value="{{old('email')}}">
                                @if($errors->has('email'))
                                    <div class="error-box">
                                        <div class="error-message">{{ $errors->first('email') }}</div>
                                        <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control @if($errors->has('confirmed_email')) alert-danger @endif" id="confirmEmail" placeholder="Please enter your email address again" name="confirmed_email" value="{{old('confirmed_email')}}">
                                @if($errors->has('confirmed_email'))
                                    <div class="error-box">
                                        <div class="error-message">{{ $errors->first('confirmed_email') }}</div>
                                        <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                    </div>
                                @endif
                            </div>

                            <div class="row no-gutters">
                                <div class="col text-left">
                                    <p class="small">By submitting this form you consent to receiving news and updates from ChingHeHuang.com. You also agree to our terms and conditions found here.</p>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-main btn-login"><i class="fa fa-check" aria-hidden="true"></i> Finish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection




@section('footer-script')

    <script type="text/javascript">

        $(document).ready(function() {
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

    </script>

    <script type="application/javascript">
        $(document).ready(function () {
            $("#country-code").text($('#country').find('option:selected').attr('data-phone'));
            $('#country').change(function () {
                var phone = $(this).find('option:selected').attr('data-phone');
                $("#country-code").text(phone);
            });
        });
    </script>
@endsection