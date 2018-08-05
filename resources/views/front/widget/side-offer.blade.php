<div class="offer-section mb-xs-0">
    <h4>Featured Content</h4>

    <!-- offer box -->
    <div class="offer-box">
        <div class="offer-wrapper">
            <img class="img-half img-wrap-text-left" src="{{ asset('/images/about/eat-clean-book.jpg') }}" alt="Eat Clean - Wok Yourself to Health by Ching-He Huang" />
            <div class="offer-intro">
                <h5>Eat Clean: Wok Yourself to Health</h5>
                <p>A REVOLUTIONARY EAST-WEST APPROACH TO EATING WELL Eat Clean and feel great with over 100 nutritious and easy Asian soups, salads and stir-fries for everyday health.</p>
                {!! str_replace('button-in-light', 'button-in-dark call-for-action text-uppercase small-90', \App\Models\RecipeSource::find(9)->getLink(true)) !!}
            </div>
            <div class="clear-float"></div>
        </div>
    </div>

    <!-- offer box -->
    <div class="offer-box">
        <a href="http://www.asianfoodchannel.com/shows/chings-amazing-asia" target="_blank">
            <img class="img-fluid" src="{{ asset('/images/offer/AmazingAsia_PreTitles_Still.jpg') }}" alt="Ching's Amazing Asia"/>
        </a>
    </div>

    <!-- offer box -->
    <div class="offer-box">
        <a href="http://www.jmldirect.com/kitchen/pots-and-pans/lotus-wok-professional-scratch-resistant-wok-and-accessories-plus-free-cookbook-by-ching-he-huang/?utm_source=ching&utm_medium=referral&utm_campaign=lotuswok10" target="_blank">
            <img class="img-fluid" src="{{ asset('/images/offer/Lotus_Wok_Cihing_update_Friday_5th_Facebook.gif') }}" alt="JML - Buy Lotus Wok" />
        </a>
    </div>

</div><!-- end of .offer-section -->