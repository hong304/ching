<div class="tab-header">
    <h5 class="tab-series-title"><i class="fa fa-lock" aria-hidden="true"></i> Change password</h5>
</div>
<form class="user-profile" action="{{route('profile/change-password')}}" method="post">
    {{csrf_field()}}
    <div class="card-block">
        <label>Current password</label>
        <input type="password" class="form-control" name="current_password" placeholder="Current password">
    </div>
    <div class="card-block">
        <label>New password</label>
        <input type="password" class="form-control" name="new_password" placeholder="New password">
    </div>
    <div class="card-block">
        <label>Confirm password</label>
        <input type="password" class="form-control" name="confirm_password" placeholder="Enter the new password again">
    </div>


    <button type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Save</button>
</form>