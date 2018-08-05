<div class="tab-header">
    <h5 class="tab-series-title"><i class="fa fa-bell" aria-hidden="true"></i> Subscription setting</h5>
</div>
<form class="user-profile" action="{{route('profile/subscription-setting')}}" method="post">
    {{ csrf_field() }}
    <div class="card-block">
        <label>Do you want to subscribe our mailing list?</label>
        <select id="subscription" class="form-control subscription select2-box"
                placeholder="Mail Subscription" name="subscription">
            <!-- please create a column in user table to let me pull the answer from db -->
            <option value="1" {{ (Auth::user()->subscription == "1" ? "selected": "") }}>YES</option>
            <option value="0" {{ (Auth::user()->subscription == "0" ? "selected": "") }}>NO</option>
        </select>
    </div>
    <button type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Save</button>
</form>