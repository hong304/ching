@extends('error')
@section('title', '404 Page Not Found')

@section('header-script')

@endsection

@section('content')




    <div class="container error-tpl">
        <div class="error-content text-center">
            <div class="content-wrapper">
                <img src="{{ asset('/images/ching-vlogo-dark.svg') }}"  alt="Ching He Huang Logo - Dark">
                <div class="error-title">The page you are trying to access cannot be found.</div>
                <a href="{{ route('index') }}" class="btn btn-main">Back to Home</a>
            </div>
        </div>
    </div>



@endsection