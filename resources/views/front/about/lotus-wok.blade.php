@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | Lotus Wok | ChingHeHuang.com')
@section('page-description', 'Learn about Ching\'s Lotus Wok, an easy-to-clean modern cookware that\'s perfect for cooking home-made Asian cuisine with an authentic taste of a traditional wok!') {{-- Defaults --}}
@section('fb-ref-image', config('app.url') . '/images/lotus-wok/ching.jpg')
@section('header-script')

@endsection



@section('content')


    <section class="offset-top bg-color white mt-xs-0">
        <div class="container mb40">
            <div class="row m0 pt40">
                <div class="col-lg-8 col-md-8 col-12 p0-xs">
                    <div class="text-left">
                        <div class="static-page-content">
                            <h1 class="static-content-title">Lotus Wok</h1>
                            <div class="full-image-holder mb24" id="lotus-wok-header">
                                <img class="img-fluid" src="{{ asset('/images/lotus-wok/lotus-wok-logo.jpg') }}"
                                     alt="Ching-He Huang's Lotus Wok"/>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-xl-6 col-12">
                                    <p class="static-content-text">Ching’s Lotus Wok is made using the latest technology
                                        to blend an authentic Asian cooking style with the superior performance of
                                        modern
                                        cookware.</p>
                                    <p class="static-content-text">Constructed from carbon steel with a flattened base,
                                        the Lotus Wok is suitable for
                                        use on every kind of hob. The scratch-resistant coating is durable enough to
                                        handle
                                        the high temperatures of stir-fry cooking as well as being suitable for metal
                                        utensil use.</p>
                                    <p class="static-content-text">Even heat distribution gives greater temperature
                                        control for better cooking results,
                                        while the traditional wooden handle is protected by a silicone core. The Lotus
                                        Wok
                                        can be used for blanching, braising, deep-frying, pan-frying, searing, smoking,
                                        steaming, stewing, and stir-frying.</p>
                                </div>
                                <div class="col-xl-6 col-12">
                                    <div class="static-content-image mb24 mb0-xs">
                                        <img src="{{ asset('/images/lotus-wok/wok-detail.png') }}"
                                             alt="The Lotus Effect - Ching-He Huang's Lotus Wok"/>
                                    </div>
                                    <p class="static-content-text">Lotus Wok’s special nano-silica coating replicates
                                        the natural properties of the
                                        lotus leaf. Like a lotus leaf, the Lotus Wok’s coating is water-repellent
                                        (hydrophobic) creating a virtual non-stick layer making it naturally easy to
                                        clean.
                                        The nano-silica coating also allows oil, essential in traditional wok cooking,
                                        to
                                        permeate the surface (oleophilic). This infuses flavour into your cooking for an
                                        authentic taste and amazing results!</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6 col-lg-7 col-12">
                                    <ul class="static-page-hl-point text-color main">
                                        <li><i class="fa fa-check-circle-o"></i> High heat resistance up to 400° C</li>
                                        <li><i class="fa fa-check-circle-o"></i> Easy to clean coating</li>
                                        <li><i class="fa fa-check-circle-o"></i> Scratch-resistant</li>
                                        <li><i class="fa fa-check-circle-o"></i> Suitable for metal utensils</li>
                                        <li><i class="fa fa-check-circle-o"></i> Efficient heat distribution CMY</li>
                                        <li><i class="fa fa-check-circle-o"></i> PTFE & PFOA free</li>
                                    </ul>
                                </div>
                                <div class="col-xl-6 col-lg-5 col-12">
                                    <div class="static-content-image" id="stick-right-bottom">
                                        <img src="{{ asset('/images/lotus-wok/ching.jpg') }}"
                                             alt="Ching-He Huang's Lotus Wok Set"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="static-bottom-offer text-center">
                                        {{--<h2 class="offer-title">Save 10% <span class="offer-sub-title">Exclusive Discount</span></h2>
                                        <h5 class="offer-main">Offer Code <span>CHH10</span></h5>
                                        <p class="small">To claim your exclusive chinghehuang.com discount, visit JMLdirect.com and enter the above code at the checkout to receive 10% off the £49.99 RRP of Lotus Wok 5pc Set. 10% OFF offer excludes P&P price (£4.95). Offer valid until 31st March.</p>--}}
                                        {{--<a href="http://www.jmldirect.com/kitchen/pots-and-pans/lotus-wok-professional-scratch-resistant-wok-and-accessories-plus-free-cookbook-by-ching-he-huang/?utm_source=ching&utm_medium=referral&utm_campaign=lotuswok10" target="_blank">Buy now</a>--}}
                                        <a href="#" class="out-of-stock">Out of Stock</a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-text with-underline" data-toggle="modal"
                                                data-target="#LotusWokModal">
                                            Notify me when back in stock
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                        <div class="alert alert-hide alert-success" role="alert" id="result-success"></div>
                                        <div class="alert alert-hide alert-danger" role="alert" id="result-error"></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end of .static-page-content -->

                        <div class="mt40 mb40 p0 hidden-sm-up">
                            <div class="title-divider"></div>
                        </div>

                        <div class="modal fade" id="LotusWokModal" tabindex="-1" role="dialog"
                             aria-labelledby="LotusWokModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Notify me when this is back in
                                            stock!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="LotusWokForm">
                                        <div class="modal-body">
                                            <div class="form-group mb-1">
                                                <input type="email" name="email" id="email-check" class="form-control"
                                                       placeholder="Your email">
                                                <div class="alert alert-hide alert-danger mt-1 p-2 small" role="alert" id="email">
                                                    Please enter a validate email.
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="checkbox" name="terms" id="terms-checkbox" value="1"> <span
                                                        class="small">I agree to the <a href="{{ route('terms-and-conditions') }}" target="_blank">Terms and Conditions</a></span>
                                                <div class="alert alert-hide alert-danger mt-1 p-2 small" role="alert" id="terms">
                                                    Please make sure you read the terms before you submit.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-start">
                                            <button type="submit" class="btn btn-main" id="LotusBtn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12 p0-xs">
                    @include('front.widget.side-offer')
                </div>

            </div><!-- end of .row -->
        </div>
    </section>


    {{--<section class="offset-top bg-color white mt-xs-0">
        <div class="container-fluid p0">
            <div class="row no-gutters">
                <div class="col">
                    <div class="static-content-image absolute-right-bottom">
                        <img src="{{ asset('/images/lotus-wok/ching.png') }}" />
                    </div>
                </div>
            </div>
            <div class="row no-gutters static-bottom-offer">
                <div class="col">
                    <img class="img-fluid" src="{{ asset('/images/lotus-wok/offer.jpg') }}" />
                </div>
            </div>
        </div>
    </section>--}}



@endsection




@section('footer-script')
    <script type="text/javascript">
    $('#LotusWokForm').submit(function (e) {
      $('#LotusBtn').text('Loading ...').prop('disabled', true);
      e.preventDefault();
      var validateEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
      if (!validateEmail.test($('#email-check').val()) || !$('#terms-checkbox').prop('checked')) {
        if (!validateEmail.test($('#email-check').val())) {
          $('#email').fadeIn();
        } else {
          $('#email').hide()
        }
        if (!$('#terms-checkbox').prop('checked')) {
          $('#terms').fadeIn();
        } else {
          $('#terms').hide()
        }
        setTimeout(function() {
          $('#LotusBtn').text('Submit').prop('disabled', false);
        }, 500)
      } else {
        $.ajax({
          method: 'post',
          url: "{{ route('lotus-wok') }}",
          data: {"_token": "{{ csrf_token() }}", email: $('#email-check').val()},
          success: function (result) {
            $('#LotusWokModal').modal('toggle')
            if (result.status) {
              $('#result-success').text(result.message).fadeIn();
            } else {
              $('#result-error').text(result.message).fadeIn();
            }
            setTimeout(function() {
              $('#LotusBtn').text('Submit').prop('disabled', false);
              document.getElementById("LotusWokForm").reset();
              setTimeout(function() {
                $('.alert').fadeOut();
              }, 5000)
            }, 500)
          }
        });
      }
    })
    </script>
@endsection