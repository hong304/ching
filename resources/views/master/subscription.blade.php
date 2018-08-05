<!-- subsciption section -->
<section class="bg-color main">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mt40 mb40 subscription-section">
                <h3 class="title-text text-color white mb24">Subscribe now for new recipes and updates!</h3>
                <form method="post" action="{{route('subscription')}}" >
                    {{csrf_field()}}
                    <input name="email" class="email_sub" id="email" type="email" placeholder="Enter Your Email">
                    <button type="submit" class="button-in-dark text-uppercase" value="">Subscribe</button>
                    {{--<div class="row">--}}
                        {{--<div class="recaptcha-position">--}}
                            {{--<div id="SubscriptionRecaptcha" class="g-recaptcha"></div>--}}
                            {{--@if($errors->has('g-recaptcha-response'))--}}
                                {{--<div class="error-box" id="recaptcha-error">--}}
                                    {{--<div class="error-message">{{ $errors->first('g-recaptcha-response') }}</div>--}}
                                    {{--<span class="error-icon"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </form>
            </div>
        </div>
    </div>
</section>