@if(count($errors))
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
@endif
@if (session('status'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif