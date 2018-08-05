@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <link rel="Stylesheet" type="text/css" href="/plugins/jquery-ui-datepicker/jquery-ui.min.css">
@endsection



@section('content')
    <section class="add-section">
        <h3 class="admin-panel-title">Send Regular EDM</h3>

        <form id="send_test_edm_form" action="{{route('adminEdm.send.test')}}" method="post">
            {{ csrf_field() }}
            @if (session('status')=='success')
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if(count($errors))
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger text-left" role="alert">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}
                    </div>
                @endforeach
            @endif
            <fieldset id="test">
                <legend>Test EDM</legend>
                <div class="card-block">
                    <label>Email For Test: </label>
                    <input type="hidden" name="id" value="{{$id}}">
                    <textarea class="form-control" name="test_emails">{{old('test_emails')}}</textarea>
                </div>
            </fieldset>
            <div class="card-block">
                <button id="submit-btn" type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Send Test EDM
                </button>
            </div>
        </form>

        <form id="send_edm_form" action="{{route('adminEdm.send')}}" method="post">
            {{ csrf_field() }}
            <fieldset id="test">
                <legend>Send EDM</legend>
                <div class="card-block">
                    <label>Press Button to send to all active users.</label>
                    <input type="hidden" name="id" value="{{$id}}">
                    <button id="submit-btn" type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Send EDM
                    </button>
                </div>
            </fieldset>

        </form>
    </section>
@endsection

@section('footer-script')
    <script src="/plugins/jquery-ui-datepicker/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#blog_date").datepicker({dateFormat: "yy-mm-dd"});
        });

    </script>
@endsection