<div class="modal fade" id="askForRegisterModal" tabindex="-1" role="dialog" aria-labelledby="askForRegisterModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content login-section">
            <div class="modal-body text-center">
                <div class="text-uppercase modal-title">Hi, I’m Ching!</div>
                <p>
                    Welcome to my site where I stock it full of recipes, videos and news.<br>
                    Become a FREE member to receive the following benefits:
                </p>
                <div class="row m0">
                    <div class="col-sm-3 col-6 pl8 pr8">
                        <img class="img-fluid" src="{{ asset('/images/icon/premium.jpg') }}" />
                        <p class="small">Access to premium online-exclusive recipes</p>
                    </div>
                    <div class="col-sm-3 col-6 pl8 pr8">
                        <img class="img-fluid" src="{{ asset('/images/icon/video.jpg') }}" />
                        <p class="small">View my online-only cookalong videos</p>
                    </div>
                    <div class="col-sm-3 col-6 pl8 pr8">
                        <img class="img-fluid" src="{{ asset('/images/icon/comment.jpg') }}" />
                        <p class="small">Comment on my content & interact directly with me</p>
                    </div>
                    <div class="col-sm-3 col-6 pl8 pr8">
                        <img class="img-fluid" src="{{ asset('/images/icon/mail.jpg') }}" />
                        <p class="small">Receive updates & new recipes straight to your mailbox</p>
                    </div>
                </div>
                <a href="{{ route('login') }}" id="first-login" class="btn btn-main btn-half toggle-modals"><i class="fa fa-sign-in"></i> Log in</a>
                <a href="{{ route('register') }}" id="first-register" class="btn btn-half btn-light-grey toggle-modals"><i class="fa fa-user-plus"></i> Sign up</a>
                <div class="clear-float"></div>
                <a class="dismiss-btn" data-dismiss="modal"><p class="small">Maybe later!</p></a>
            </div>
        </div>
    </div>
</div>