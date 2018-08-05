<div class="modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content login-section">
            <div class="modal-header text-center">
                <a data-dismiss="modal"><i class="fa fa-times form-close-btn"></i></a>
                <div class="text-uppercase modal-title">Member Log in</div>
            </div>
            <div class="modal-body">
                @if(count($errors) && session('from')=='login')
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger text-left" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}</div>
                    @endforeach
                @endif
                @if (session('facebook_error'))
                    <div class="alert alert-danger text-left" role="alert">
                        {{ session('facebook_error') }}
                    </div>
                @endif
                @if(session()->has('status') && session('from')=='login')
                    <div class="alert alert-{{session('status')}}" role="alert">{{ session('message') }}</div>
                @endif

                <form method="post" action="{{ route('login') }}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <a href="{{ url('auth/facebook') }}" class="btn btn-block btn-fb"><i class="fa fa-facebook"></i> Log in with Facebook</a>
                        {{--<a href="www.google.com" class="btn btn-block btn-google"><i class="fa fa-google"></i> Log in with Google</a>--}}
                    </div>
                    <div class="panel-divider"><span>or</span></div>
                    <input type="hidden" value="/" name="redirect" id="redirect_url">
                    <div class="form-group">
                        <input type="email" class="form-control" id="loginEmail" placeholder="Email address" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="loginPassword" placeholder="Password" name="password" value="{{old('password')}}">
                    </div>
                    <div class="row">
                        <div class="col-6 text-left">
                            <label for="remember" class="checkbox">
                                <input id="remember" type="checkbox" name="remember"> Keep me logged in
                            </label>
                        </div>
                        <div class="col-6 text-right">
                            <a href="javascript:void(0);" class="toggle-modals" data-toggle-modal="#forgotpasswordModal">Forgot password?</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-main btn-half btn-login" id="first"><i class="fa fa-sign-in"></i> Log in</button>
                    <a data-toggle="modal" data-target="#registerModal" class="btn btn-half btn-light-grey call-register-modal"><i class="fa fa-user-plus"></i> Sign up</a>
                </form>
            </div>
        </div>
    </div>
</div>