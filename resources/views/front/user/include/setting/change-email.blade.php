<div class="tab-header">
    <h5 class="tab-series-title"><i class="fa fa-envelope" aria-hidden="true"></i> Change email</h5>
</div>
<form class="user-profile" action="{{route('profile/change-email')}}" method="post">
    {{ csrf_field() }}
    <div class="card-block">
        <label>New email</label>
        <input type="email" class="form-control" name="email" placeholder="New email">
    </div>
    <div class="card-block">
        <label>Confirmed new email</label>
        <input type="email" class="form-control" name="confirmed_email" placeholder="Confirmed new email">
    </div>
    <div class="card-block">
        <label>Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Save</button>
</form>