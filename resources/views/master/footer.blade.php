<div class="bottomMenu bg-color dark-blue pt40">
    <div class="row m0 standard-padding">
        <div class="col-12 text-color white">
            <div class="row m0 mb40">
                <div class="col-lg-3 col-md-6 col-sm-6 col-6 p0">
                    <a class="footer-brand" href="{{route('index')}}"><img id="logo-dark" src="/images/ching-logo-light.svg" alt="Ching-He Huang Logo - Light" /></a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6 p0">
                    <div class="social-btn">
                        <a href="https://www.facebook.com/ChingHeHuangOfficial/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                        <a href="https://instagram.com/chinghehuang" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="https://twitter.com/chinghehuang" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
                        <a href="https://www.youtube.com/user/chinghehuang" target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="row m0">
                <div class="col p0">
                    <div class="row menu-list mb40">
                        <ul class="col-sm-3 col-6">
                            <li><a href="{{route('recipe')}}" class="list-header">Recipes</a>
                                <ul class="sub-menu-list">
                                    <li><a href="{{ route('recipe-search',['all','chicken']) }}" >Chicken</a></li>
                                    <li><a href="{{ route('recipe-search',['all','pork']) }}" >Pork</a></li>
                                    <li><a href="{{ route('recipe-search',['all','vegetarian']) }}" >Vegetarian</a></li>
                                    <li><a href="{{ route('recipe-search',['all','seafood']) }}" >Seafood</a></li>
                                    <li><a href="{{ route('recipe-search',['all','salad']) }}" >Salad</a></li>
                                    <li><a href="{{ route('recipe-search',['main-courses']) }}">Main course</a></li>
                                    <li><a href="{{ route('recipe-search',['snacks-and-sides']) }}">Snacks & Sides</a></li>
                                    <li><a href="{{ route('recipe-search',['starter']) }}">Starter</a></li>
                                    <li><a href="{{ route('recipe-search',['dessert']) }}">Dessert</a></li>
                                    <li><a href="{{ route('recipe-search',['soup']) }}">Soup</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="col-sm-3 col-6">
                            <li><a href="{{route('all-video')}}" class="list-header">Videos</a>
                                <ul class="sub-menu-list">
                                    <li><a href="{{ route('video-series', 'flavology') }}" >Flavology</a></li>
                                    <li><a href="{{ route('video-series', 'click-and-cook') }}" >Click & Cook</a></li>
                                    <li><a href="{{ route('video-series', 'hot-off-the-wok') }}" >Hot Off The Wok</a></li>
                                    <li><a href="{{ route('video-series', 'lee-kum-kee-shorts') }}" >Lee Kum Kee</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="col-sm-3 col-6">
                            <li><a href="{{ route('blog') }}" class="list-header">Blogs</a>
                                <ul class="sub-menu-list">
                                    <li><a href="{{ route('blog', 'Food') }}">Food</a></li>
                                    <li><a href="{{ route('blog', 'Inspiration') }}">Inspiration</a></li>
                                    <li><a href="{{ route('blog', 'News') }}">News</a></li>
                                    <li><a href="{{ route('blog', 'Charity') }}">Charity</a></li>
                                </ul>
                            </li>
                        </ul><ul class="col-sm-3 col-6">
                            <li><a href="#" class="list-header">Others</a>
                                <ul class="sub-menu-list">
                                    <li><a href="{{ route('lotus-wok') }}">Lotus Wok</a></li>
                                    <li><a href="{{ route('books') }}">Books</a></li>
                                    <li><a href="{{ route('amazing-asia') }}">Amazing Asia</a></li>
                                    <li><a href="{{ route('biography') }}">Biography</a></li>
                                    <li><a href="{{ route('my-story') }}">My Story</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-center text-color white">
            <ol class="privacy-section mb0">
                <a href="{{ route('privacy-policy') }}"><li>Privacy Policy</li></a>
                <li>|</li>
                <a href="{{ route('terms-and-conditions') }}"><li>Terms and Conditions</li></a>
                <li>|</li>
                <a href="{{ route('contact') }}"><li>Contact</li></a>
            </ol>
        </div>
        <div class="col-12 text-center text-color white mb0 pb8 copy-right">
            © {{date("Y")}} Ching He Huang. All rights reserved.
        </div>
    </div>
</div>