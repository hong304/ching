<div class="modal" id="registerModal" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content login-section">
            <div class="modal-header text-center">
                <a data-dismiss="modal"><i class="fa fa-times form-close-btn"></i></a>
                <div class="text-uppercase modal-title">Sign up a new account</div>
            </div>
            <div class="modal-body">
                <p class="small-90 mb40">Sign up free for access to loads of Ching's favorite recipes and videos. Get the latest recipes as well as exclusive promotions and offers direct to your inbox.</p>
                @if (session('status')=='success' && session('from')=='register')
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session('facebook_error'))
                    <div class="alert alert-danger">
                        {{ session('facebook_error') }}
                    </div>
                @endif
                <form method="post" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <a href="{{ url('auth/facebook') }}" class="btn btn-block btn-fb"><i class="fa fa-facebook"></i> Log in with Facebook</a>
                        {{--<a href="www.google.com" class="btn btn-block btn-google"><i class="fa fa-google"></i> Log in with Google</a>--}}
                    </div>
                    <div class="panel-divider"><span>or create a new account</span></div>
                    <div class="form-group two-tabs" id="first">
                        <input type="text" class="form-control @if($errors->has('first_name') && session('from') == 'register') alert-danger @endif" id="firstName" placeholder="First name *" name="first_name" value="{{old('first_name')}}">
                        @if($errors->has('first_name') && session('from') == 'register')
                            <div class="error-box">
                                <div class="error-message">{{ $errors->first('first_name') }}</div>
                                <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group two-tabs">
                        <input type="text" class="form-control @if($errors->has('last_name') && session('from') == 'register') alert-danger @endif" id="lastName" placeholder="Last name *" name="last_name" value="{{old('last_name')}}">
                        @if($errors->has('last_name') && session('from') == 'register')
                            <div class="error-box">
                                <div class="error-message">{{ $errors->first('last_name') }}</div>
                                <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group two-tabs" id="first">
                        <select id="gender" class="form-control gender select2-box" placeholder="Please select gender" name="gender" value="{{old('gender')}}">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group two-tabs">
                        <input type="email" class="form-control @if($errors->has('email') && session('from') == 'register') alert-danger @endif" id="loginEmail" placeholder="Email address *" name="email" value="{{old('email')}}">
                        @if($errors->has('email') && session('from') == 'register')
                            <div class="error-box">
                                <div class="error-message">{{ $errors->first('email') }}</div>
                                <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group clear-float">
                        <select id="country" class="form-control country select2-box" placeholder="Please select your country" name="country_code" value="{{old('country_code')}}">
                            <option value="" disabled selected>Please select your country</option>
                            @foreach( $countries as $key=>$country_code)
                                <option value="{{$country_code['country_code']}}" {{ (old('country_code', $currentCountry->country_code) == $country_code['country_code'] ? "selected": "") }} data-flag="{{$country_code['flag_icon']}}" data-phone="+{{$country_code['calling_code']}}">{{$country_code['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="mobile-card">
                        <input type="text" class="form-control" id="mobileNum" placeholder="Mobile phone" name="tel_mobile" value="{{old('tel_mobile')}}">
                        <span id="country-code">{{$currentCountry->calling_code}}</span>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control @if($errors->has('password') && session('from') == 'register') alert-danger @endif" id="password" placeholder="Password *" name="password" value="">
                        @if($errors->has('password') && session('from') == 'register')
                            <div class="error-box">
                                <div class="error-message">{{ $errors->first('password') }}</div>
                                <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control @if($errors->has('password_confirmation') && session('from') == 'register') alert-danger @endif" id="password_confirmation" placeholder="Confirm Password *" name="password_confirmation" value="">
                        @if($errors->has('password_confirmation') && session('from') == 'register')
                            <div class="error-box">
                                <div class="error-message">{{ $errors->first('password_confirmation') }}</div>
                                <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <div id="RegisterRecaptcha"></div>
                        @if($errors->has('g-recaptcha-response') && session('from') == 'register')
                            <div class="error-box" id="recaptcha-error">
                                <div class="error-message">{{ $errors->first('g-recaptcha-response') }}</div>
                                <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                            </div>
                        @elseif($errors->has('captcha') && session('from') == 'register')
                            <div class="error-box" id="recaptcha-error">
                                <div class="error-message">{{ $errors->first('captcha') }}</div>
                                <span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col text-left">
                            <p class="small">By submitting this form you consent to receiving news and updates from ChingHeHuang.com. You also agree to our terms and conditions found <a href="{{ route('terms-and-conditions') }}" target="_blank">here</a>.</p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-main btn-half btn-login" id="first"><i class="fa fa-user-plus"></i> Sign up</button>
                    <a class="btn btn-half btn-light-grey toggle-modals" data-toggle-modal="#loginModal"><i class="fa fa-sign-in"></i> Log in</a>
                </form>
            </div>
        </div>
    </div>
</div>

