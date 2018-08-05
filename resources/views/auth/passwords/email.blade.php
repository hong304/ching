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
                        <h2 class="text-uppercase">Forgot Password</h2>
                        <p class="text-color medium-grey small-90">If you have forgotten your password, please fill in the form below. We will send you instructions to reset your password.</p>

                        @if(count($errors))
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger text-left" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}</div>
                            @endforeach
                        @endif

                        <form method="post" action="{{route('forgotPassword')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="email" class="form-control" id="loginEmail" placeholder="Enter Email Address" name="email">
                            </div>
                            <button type="submit" class="btn btn-block btn-main"><i class="fa fa-lock"></i> Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-center">
                    <p class="small mb-0"><a href="{{ route('login') }}"><i class="fa fa-lightbulb-o"></i> Wait, I remember my password!</a></p>
                </div>
            </div>
        </div>
    </section>


@endsection



@section('footer-script')

@endsection