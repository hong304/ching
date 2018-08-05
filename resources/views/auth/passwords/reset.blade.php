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
                        <h2 class="text-uppercase">Reset Password</h2>

                        @if(count($errors))
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger text-left" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}</div>
                            @endforeach
                        @endif

                        <form method="post" action="{{route('resetPassword')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="token" value="{{$token}}" />
                            <div class="form-group">
                                <input type="email" class="form-control" id="loginEmail" placeholder="Email address" name="email" value="{{$email}}">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="newPassword" placeholder="Enter your new password" name="password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your new password" name="password_confirmation">
                            </div>
                            <button type="submit" class="btn btn-block btn-submit"><i class="fa fa-unlock-alt"></i> Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection



@section('footer-script')

@endsection




@section('footer-script')

@endsection