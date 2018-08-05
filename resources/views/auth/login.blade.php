@extends('blank')
@section('title', 'Reset password')
@section('header-script')

@endsection

@section('content')



    <section class="blank-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col text-center mt-5">
                    <div class="text-center login-section light-shadow">
                        <a href="{{route('index')}}"><img class="title-logo vectical-logo" id="logo-dark" src="/images/ching-vlogo-dark.svg" alt="Ching He Huang Logo - Dark"/></a>
                        <h2 class="text-uppercase">Member Log in</h2>
                        @if(count($errors))
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger text-left" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}</div>
                            @endforeach
                        @endif
                        @if (session('facebook_error'))
                            <div class="alert alert-danger text-left" role="alert">
                                {{ session('facebook_error') }}
                            </div>
                        @endif
                        @if(session()->has('message'))
                                <div class="alert alert-{{session('status')}}" role="alert">{{ session('message') }}</div>
                        @endif

                        <form method="post" action="{{ route('login') }}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="email" class="form-control" id="loginEmail" placeholder="Email address" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="loginPassword" placeholder="Password" name="password" value="{{old('password')}}">
                            </div>
                            <div class="row">
                                <div class="col-6 text-left">
                                    <label for="remember" class="checkbox remember-label">
                                        <input id="remember" type="checkbox" name="remember"> Keep me logged in
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{route('getForgotPassword')}}" class="forgot-label">Forgot password?</a>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-login"><i class="fa fa-sign-in"></i> Log in</button>
                            <div class="panel-divider"><span>or</span></div>
                            <div class="form-group mb-0">
                                <a href="{{ url('auth/facebook') }}" class="btn btn-block btn-fb"><i class="fa fa-facebook-official"></i> Log in with Facebook</a>
                                {{--<a href="www.google.com" class="btn btn-block btn-google"><i class="fa fa-google"></i> Log in with Google</a>--}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-center">
                    <p class="small mb-0">Don't have an account? <a href="{{ route('register') }}"><strong>Get it now</strong></a></p>
                </div>
            </div>
        </div>
    </section>


@endsection



@section('footer-script')

@endsection