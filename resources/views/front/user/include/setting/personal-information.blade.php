<div class="tab-header">
    <h5 class="tab-series-title"><i class="fa fa-id-card" aria-hidden="true"></i> Personal information</h5>
</div>
<form class="user-profile" action="{{route('personalinformation')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <!-- first name -->
    <div class="card-block">
        <label>Name *</label>
        <input type="text" class="form-control" name="first_name" placeholder="First Name *"
               value="{{old('first_name', Auth::user()->first_name)}}">
    </div>
    <!-- last name -->
    <div class="card-block">
        <input type="text" class="form-control" name="last_name" placeholder="Last Name *"
               value="{{old('last_name', Auth::user()->last_name)}}">
    </div>
    <!-- nickname -->
    <div class="card-block">
        <input type="text" class="form-control" name="nick_name" placeholder="Nick Name"
               value="{{old('nick_name', Auth::user()->nick_name)}}">
    </div>
    <!-- sex -->
    <div class="card-block">
        <label>Gender</label>
        <br>
        <label class="custom-control custom-radio">
            <input id="male" name="gender" value="male" type="radio"
                   class="custom-control-input" {{ (old('gender', Auth::user()->gender) == "male" ? "checked": "") }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Male</span>
        </label>
        <label class="custom-control custom-radio">
            <input id="radio2" name="gender" value="female" type="radio"
                   class="custom-control-input" {{ (old('gender', Auth::user()->gender) == "female" ? "checked": "") }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Female</span>
        </label>
        <label class="custom-control custom-radio">
            <input id="radio2" name="gender" value="other" type="radio"
                   class="custom-control-input" {{ (old('gender', Auth::user()->gender) == "other" ? "checked": "") }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Other</span>
        </label>
    </div>
    <!-- country selector -->
    <div class="card-block">
        <label>Country</label>
        <select id="country" class="form-control country"
                placeholder="Please select your country" name="country">
            <option value disabled selected>Please select your country</option>
            @foreach( $countries as $country)
                <option value="{{$country['country_code']}}" {{ (old('country', Auth::user()->country_code) == $country['country_code'] ? "selected": "") }} data-flag="{{$country['flag_icon']}}" data-phone="+{{$country['calling_code']}}">{{$country['name']}}</option>
            @endforeach
        </select>
    </div>
    <!-- birthday -->
    <div class="card-block">
        <label>Birthday</label>
        <input type="text" class="form-control" name="birthday" placeholder="YYYY-mm-dd"
               value="{{old('birthday', Auth::user()->birthday)}}" id="birthday">
    </div>
    <!-- mobile -->
    <div class="card-block" id="mobile-card">
        <label>Mobile/Cell phone</label>
        <input type="tel" class="form-control" id="mobileNum" placeholder="Mobile phone"
               name="phone" value="{{old('phone',Auth::user()->phone)}}">
        <span id="country-code"></span>
    </div>

    <button type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Save
    </button>
</form>