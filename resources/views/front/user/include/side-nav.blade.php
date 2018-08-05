<div class="user-avatar">
    <div class="avatar-holder">

        <label class="edit-avatar-btn"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></label>
        <input type="file" id="avatar_file">
        @if (isset(Auth::user()->avatar))
            <img src="{{Storage::url(Auth::user()->avatar)}}" >
        @elseif (isset(Auth::user()->facebook_id))
            <img src="https://graph.facebook.com/{{ Auth::user()->facebook_id }}/picture?width=320&height=320" >
        @else
            <img src="/images/avatar-img.svg" >
        @endif
    </div>
</div>
<div class="profile-tab-nav">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link" href="#personalinformation" role="tab" data-toggle="tab" id="nav-personalinformation">Personal information</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#changepassword" role="tab" data-toggle="tab" id="nav-changepassword">Change password</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#changeemail" role="tab" data-toggle="tab" id="nav-changeemail">Change email</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#subscriptionsetting" role="tab" data-toggle="tab" id="nav-subscriptionsetting">Subscription setting</a>
        </li>
    </ul>
</div>

<!--Avatar Modal -->
<div class="modal fade" id="avatar_modal" tabindex="-1" role="dialog" aria-labelledby="avatar_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Avatar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="avatar_form" action="{{route('profile/change-avatar')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div id="cropper"></div>
                    <input type="hidden" id="avatar_cropped" name="avatar">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-avatar">Save changes</button>
            </div>
        </div>
    </div>
</div>