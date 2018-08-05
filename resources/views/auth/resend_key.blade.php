@extends('master')

@section('title', 'Resend password')

@section('header-script')

@endsection



@section('content')

    <section>
        <div class="container-fluid blank-background">
            <div class="row">
                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-10 col offset-xl-3 offset-lg-2 offset-md-2 offset-sm-1">
                    <div class="popup-box">
                        <h2>Resent Activation Key</h2>
                        <p class="small-90">Please enter your email address, and we'll resend you a link active your account.</p>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if(count($errors))
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger text-left" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}</div>
                            @endforeach
                        @endif
                        <form method="post" action="{{route('activation_key_resend')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="email" class="form-control" id="loginEmail" placeholder="Email address" name="email">
                            </div>
                            <button type="submit" class="btn btn-block btn-main"><i class="fa fa-lock"></i> Resend Activation Key</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection




@section('footer-script')

@endsection