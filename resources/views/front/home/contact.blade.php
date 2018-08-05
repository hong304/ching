@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | Contact us | ChingHeHuang.com')
@section('page-description','To enquire about Ching\'s services, check the contact details listed here. For products or services offered by ChingHeHuang.com, fill in page\'s provided form.')
@section('fb-ref-image', config('app.url') . '/images/carousel/see-ching-in-action.jpg')
@section('header-script')

@endsection

@section('content')

    <section class="offset-top bg-color white">
        <div class="container pt40 mb40">
            <div class="row m0">
                <div class="col-md-8 col-12 offset-md-2">
                    <div class="text-md-left text-center">
                        <div class="static-page-content">
                            <h1 class="static-content-title text-uppercase">Contact</h1>

                            <h5>General Enquiries</h5>
                            <p class="mb40">To ask about Ching's services or any general questions about Ching herself,
                                please email :<br>
                                <a href="mailto:info@chinghehuang.com">info@chinghehuang.com</a></p>
                            <hr>
                            <h1 class="static-content-title text-uppercase">Enquiry Form</h1>
                            <p class="small-90">For more information on any of the products or services offered by
                                www.chinghehuang.com, please complete the form below or email us directly at <a
                                        href="mailto:info@chinghehuang.com">info@chinghehuang.com</a></p>
                            <form class="" method="post" action="{{route('enquiry')}}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="text"
                                           class="form-control @if($errors->has('first_name') && session('from') == 'contact') alert-danger @endif"
                                           id="firstName" placeholder="First name" name="first_name" value="{{ old('first_name') }}">
                                    @if($errors->has('first_name') && session('from') == 'contact')
                                        <div class="error-box">
                                            <div class="error-message">{{ $errors->first('first_name') }}</div>
                                            <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text"
                                           class="form-control @if($errors->has('last_name') && session('from') == 'contact') alert-danger @endif"
                                           id="lastName" placeholder="Last name" name="last_name" value="{{old('last_name')}}">
                                    @if($errors->has('last_name') && session('from') == 'contact')
                                        <div class="error-box">
                                            <div class="error-message">{{ $errors->first('last_name') }}</div>
                                            <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="email"
                                           class="form-control @if($errors->has('email') && session('from') == 'contact') alert-danger @endif"
                                           id="loginEmail" placeholder="Email address" name="email" value="{{old('email')}}">
                                    @if($errors->has('email') && session('from') == 'contact')
                                        <div class="error-box">
                                            <div class="error-message">{{ $errors->first('email') }}</div>
                                            <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <textarea rows="4"
                                              class="form-control @if($errors->has('message') && session('from') == 'contact') alert-danger @endif"
                                              id="message" placeholder="Message" name="message">{{old('message')}}</textarea>
                                    @if($errors->has('message') && session('from') == 'contact')
                                        <div class="error-box">
                                            <div class="error-message">{{ $errors->first('message') }}</div>
                                            <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div id="ContactRecaptcha" class="g-recaptcha" data-sitekey="{{ config('app.google_recap_key') }}"></div>
                                    @if($errors->has('g-recaptcha-response') && session('from') == 'contact')
                                        <div class="error-box" id="recaptcha-error">
                                            <div class="error-message">{{ $errors->first('g-recaptcha-response') }}</div>
                                            <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                        </div>
                                    @elseif($errors->has('captcha') && session('from') == 'contact')
                                        <div class="error-box" id="recaptcha-error">
                                            <div class="error-message">{{ $errors->first('captcha') }}</div>
                                            <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                        </div>
                                    @endif
                                </div>
                                <br/>
                                <button type="submit" class="btn btn-block btn-login"> Submit</button>
                            </form>
                        </div><!-- end of .static-page-content -->

                    </div>
                </div>

            </div><!-- end of .row -->
        </div>
    </section>

    @if (session('status') == 'success')
        <div class="screen-overlay">
            <div class="popup-box successful-popup">
                <div class="label-check-icon"><i class="fa fa-check"></i></div>
                <div class="message-title">@if (session('subscription_title')) {{ session('subscription_title') }} @else {{ session('status') }} @endif</div>
                <p class="small-90">{{ session('message') }}</p>
                <button class="btn btn-main popup-close-btn">Close</button>
            </div>
        </div>
    @endif
@endsection

@section('footer-script')
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <script>
        $(document).ready(function () {
            $('.screen-overlay').click(function() {
                $(this).fadeOut("slow");
            });

            $('.popup-close-btn').click(function() {
                $('.screen-overlay').fadeOut("slow");
            });

            $('.message-close-btn').click(function() {
                $('.message-box').fadeOut("slow");
            });
        });
    </script>
@endsection