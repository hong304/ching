<div class="register-overlay" id="ask-for-register">
    <div class="popup-box alert-popup">
        <div class="message-holder">
            <div class="text-uppercase popup-title">Hi, I’m Ching!</div>
            <p class="small-90">
                Welcome to my site where I stock it full of recipes, videos and news. <br>
                Become a FREE member to receive the following benefits:
            </p>
            <div class="row m0">
                <div class="col pl8 pr8">
                    <img class="img-fluid" src="{{ asset('/images/icon/premium.jpg') }}" />
                    <p class="small">Access to premium online-exclusive recipes</p>
                </div>
                <div class="col pl8 pr8">
                    <img class="img-fluid" src="{{ asset('/images/icon/video.jpg') }}" />
                    <p class="small">View my online-only cookalong videos</p>
                </div>
                <div class="col pl8 pr8">
                    <img class="img-fluid" src="{{ asset('/images/icon/comment.jpg') }}" />
                    <p class="small">Comment on my content & interact directly with me</p>
                </div>
                <div class="col pl8 pr8">
                    <img class="img-fluid" src="{{ asset('/images/icon/mail.jpg') }}" />
                    <p class="small">Receive updates & new recipes straight to your mailbox</p>
                </div>
            </div>
            <a id="go-to-login" href="{{ route('login') }}" class="btn btn-main btn-half first"><i class="fa fa-sign-in"></i> Login</a>
            <a id="go-to-register" href="{{ route('register') }}" class="btn btn-half btn-light-grey"><i class="fa fa-user-plus"></i> Register</a>
            <div class="clear-float"></div>
        </div>
    </div>
</div>