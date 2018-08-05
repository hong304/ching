@extends('error')
@section('title', '500 Something Error')

@section('header-script')

@endsection

@section('content')


    <div class="container error-tpl">
        <div class="error-content text-center">
            <div class="content-wrapper">
                <img src="{{ asset('/images/ching-vlogo-dark.svg') }}" alt="Ching He Huang Logo - Dark">
                <div class="error-title">Oh dear, it seems we’re experiencing a technical problem.
                    <br>Please try again later or contact <a href="mailto:info@chinghehuang.com" target="_blank">info@chinghehuang.com</a>
                </div>
<br>
                @if(isset($message))
                    <div class="error">{{ $message }}
                        @if(isset($code))
                            (error code {{ $code }})
                        @endif
                    </div>
                @endif

                @if(isset($exception))
                    <div class="error">{{ $exception->getMessage() }}</div>
                @endif

                <a href="{{ route('index') }}" class="btn btn-main">Back to Home</a>
            </div>
        </div>
    </div>



@endsection