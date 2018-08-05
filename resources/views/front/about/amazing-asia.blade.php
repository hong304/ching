@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | Amazing Asia | ChingHeHuang.com')
@section('page-description', 'Discover the restaurants and locations featured in Ching\'s Amazing Asia, hosted by Emmy nominated TV chef and cookery author Ching He Huang.') {{-- Defaults --}}
@section('fb-ref-image', config('app.url') . '/images/amazing-asia/amazing-asia.jpg')
@section('header-script')

@endsection



@section('content')

    <section class="offset-top bg-color white">
        <div class="container-fluid p0">
            <div class="row no-gutters">
                <div class="col">
                    <div class="full-image-holder smaller" style="background-image: url('{{ asset('/images/amazing-asia/amazing-asia.jpg') }}');">
                        <div class="image-text-overlay">
                            <h1 class="text-overlay-title">Ching's Amazing Asia</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-color white mt40 mt-xs-16">
        <div class="container mb40">
            <div class="row no-gutters">
                <div class="col-md-10 col-12 offset-md-1 offset-0">
                    <div class="text-left">
                        <div class="static-page-content standard-padding" id="amazing-asia">


                            <div class="amazing-asia-tab-nav">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#hongkong" role="tab" data-toggle="tab" id="nav-hongkong">Hong Kong</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#macao" role="tab" data-toggle="tab" id="nav-macao">Macao</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#taipei" role="tab" data-toggle="tab" id="nav-taipei">Taipei</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#okinawa" role="tab" data-toggle="tab" id="nav-okinawa">Okinawa</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tokyo" role="tab" data-toggle="tab" id="nav-tokyo">Tokyo</a>
                                    </li>
                                    <div class="clear-float"></div>
                                </ul>
                            </div>


                            <!-- Tab box -->
                            <div class="amazing-asia-tab-box">
                                <div class="tab-content">

                                    <!-- the hong kong tab -->
                                    <div role="tabpanel" class="tab-content-holder tab-pane fade" id="hongkong">
                                        <div class="row no-gutters">
                                            <div class="col-md-8 col-sm-7 col-12">
                                                <h2 class="static-content-title">Hong Kong</h2>
                                                <p class="static-content-text">If you want to experience the true vibrant spirit of modern Asia, look no further that Hong Kong. Simply thriving with life, from local tradition to high-end luxury, this twenty-first century city caters to all tastes an interests. I always love that first glimpse of Hong Kong Island's glittering skyline seen from across the harbour - it's so iconic, and the food? it's out of this world!</p>
                                            </div>
                                            <div class="col-md-4 col-sm-5 col-12">
                                                <img class="img-fluid" src="{{ asset('/images/amazing-asia/hk/hk.jpg') }}" />
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="static-list-title">Restaurants</h5>
                                        <ul class="static-list row no-gutters">
                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Little Bao <a href="http://www.little-bao.com/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> May Chow
                                                <br><span class="special-dish">Speciality dish:</span> Szechuan Fried Chicken Bao & Mentaiko Mac 'n Cheese
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Sing Hueng Yuen
                                                <br><span class="special-dish">Speciality dish:</span> Tomato and Macaroni Soup & Crispy Crispy
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Gi Kee
                                                <br><span class="chef-name">Head Chef:</span> Chan Chong Fei
                                                <br><span class="special-dish">Speciality dish:</span> Lobster Noodles & XO Scallops
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Yan Toh Heen <a href="https://hongkong-ic.intercontinental.com/zh-hant/dining/yan_toh_heen.php" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Lai Yiu Fai
                                                <br><span class="special-dish">Speciality dish:</span> Roasted Suckling Pig wth Lobster & Wagyu Beef Stir Fry
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Tim Ho Wan <a href="http://www.timhowan.com/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Mak Kwai Pui
                                                <br><span class="special-dish">Speciality dish:</span> Golden Spring Rolls & Snow Topped BBQ Pork Bao
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Lee Kueng Kee
                                                <br><span class="special-dish">Speciality dish:</span> Egg Waffles
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Mamasan <a href="http://www.mamasanhongkong.com/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Gede Budiana
                                                <br><span class="special-dish">Speciality dish:</span> Chilli Harbour Prawns & Ubud style Pork Ribs
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Kam Wah Café
                                                <br><span class="chef-name">Head Chef:</span> Mrs Chan
                                                <br><span class="special-dish">Speciality dish:</span> Pineapple Bun & Yin Yong Tea
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Shang Palace <a href="http://www.shangri-la.com/hongkong/kowloonshangrila/dining/restaurants/shang-palace/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Mok Kit Kueng
                                                <br><span class="special-dish">Speciality dish:</span> Wok Seared Lamb
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Stack
                                                <br><span class="chef-name">Head Chef:</span> Joshua Ng
                                                <br><span class="special-dish">Speciality dish:</span> Pork Collar Pancake & Runny Honey Stack
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Lab Made Ice <a href="http://www.labmade.com.hk/home.aspx" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="special-dish">Speciality dish:</span> Matcha Green Tea Ice cream & Liquid Nitrogen & Lychee Rose Dry Ice Tea
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Lin Hueng Kui
                                                <br><span class="chef-name">Head Chef:</span> Lee Yun Ming
                                                <br><span class="special-dish">Speciality dish:</span> Har Gau Shrimp dumplings
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Kung Wo Do Bun
                                                <br><span class="special-dish">Speciality dish:</span> Tofu Combo plate
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Ho Lee Fook <a href="http://holeefookhk.tumblr.com/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Jowett Yu
                                                <br><span class="special-dish">Speciality dish:</span> Mom's Mostly Cabbage Little Bit of Pork Dumplings & Slightly Fires the Emperor
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Temple Street Spice Crab
                                                <br><span class="special-dish">Speciality dish:</span> Spicy Crab
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Chilli Fagara <a href="http://www.chillifagara.com" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Chan, Kai Ying
                                                <br><span class="special-dish">Speciality dish:</span> Emperor's Chilli Prawns & Crispy Spicy Beef
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Mak's Noodles
                                                <br><span class="special-dish">Speciality dish:</span> Wonton Noodle Soup
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> BEP <a href="http://www.bep.hk/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Helen
                                                <br><span class="special-dish">Speciality dish:</span> Beef Pho
                                            </li>
                                        </ul>
                                    </div>


                                    <!-- the macao tab -->
                                    <div role="tabpanel" class="tab-content-holder tab-pane fade" id="macao">
                                        <div class="row no-gutters">
                                            <div class="col-md-8 col-sm-7 col-12">
                                                <h2 class="static-content-title">Macao</h2>
                                                <p class="static-content-text">Macao is one of the oldest fusion cultures in the world - a unique mix of Chinese and Portuguese heritage. East meets West here and I think they've definitely got the best of both worlds! This ranges from UNESCO World Heritage architecture to traditional Chinese festivals of fireworks and dragon boats, and ultra-modern hotels and nightlife. Plus I would say the Macanese cuisine, with its unmistakable blend of eastern and western flavours, is worth a visit all by itself!</p>
                                            </div>
                                            <div class="col-md-4 col-sm-5 col-12">
                                                <img class="img-fluid" src="{{ asset('/images/amazing-asia/mc/mc.jpg') }}" />
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="static-list-title">Restaurants</h5>
                                        <ul class="static-list row no-gutters">
                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> David Wong at IFT
                                                <br><span class="chef-name">Head Chef:</span> David Wong
                                                <br><span class="special-dish">Speciality dish:</span> African Chicken & Portuguese Chorizo Clams
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Chan Kong Wei
                                                <br><span class="special-dish">Speciality dish:</span> Black Pepper Duck
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Belos Tempos
                                                <br><span class="chef-name">Head Chef:</span> Anna Manhao Sou
                                                <br><span class="special-dish">Speciality dish:</span> Macanese Minchi
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Café Nam Ping
                                                <br><span class="chef-name">Head Chef:</span> Leong Yu Der
                                                <br><span class="special-dish">Speciality dish:</span> Char Siu Egg Sandwich & Sai Yung Bau
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> The Eight <a href="http://www.grandlisboa.com/en/food_and_beverage/index_id_1.html" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Yueng Kok Chio
                                                <br><span class="special-dish">Speciality dish:</span> A5 Kagoshima Beef Rolls with Water Spinach & Shredded Chicken with Crispy Skin and Pomelo
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Antonio <a href="http://antoniomacau.com/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Antonio Coelho
                                                <br><span class="special-dish">Speciality dish:</span> Seafood Cataplana & Grilled Sardines
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Lord Stow's Bakery <a href="http://www.lordstow.com/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="special-dish">Speciality dish:</span> Egg Tarts
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Seng Cheong
                                                <br><span class="chef-name">Head Chef:</span> Chan Wai Fan
                                                <br><span class="special-dish">Speciality dish:</span> Crab Congee & Salt and Pepper Squid
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Tak Lei Lo Kei
                                                <br><span class="special-dish">Speciality dish:</span> Pork Bun Chop
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Jade Dragon <a href="http://www.cityofdreamsmacau.com/en/dining/detail/jade-dragon" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Tam Kwok Fung
                                                <br><span class="special-dish">Speciality dish:</span> Iberico Char Siu Pork & Lychee Wood BBQ Goose
                                            </li>

                                        </ul>
                                    </div>



                                    <!-- the taipei tab -->
                                    <div role="tabpanel" class="tab-content-holder tab-pane fade" id="taipei">
                                        <div class="row no-gutters">
                                            <div class="col-md-8 col-sm-7 col-12">
                                                <h2 class="static-content-title">Taipei</h2>
                                                <p class="static-content-text">Taipei city is the capital of Taiwan and a modern metropolis with busy shopping streets and contemporary buildings. Taipei is known for its lively night markets and street-food scene. Rich in beautiful, Minnan-style temples, heritage lanes and nature preserves, it's a buzzing city growing in reputation. The food here is an eclectic mix of rural Taiwanese, Chinese and the best of Japanese to create it's own unique fusion cuisine. Taiwanese foods are assertive, aromatic and rich in flavour.</p>
                                            </div>
                                            <div class="col-md-4 col-sm-5 col-12">
                                                <img class="img-fluid" src="{{ asset('/images/amazing-asia/tp/tp.jpg') }}" />
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="static-list-title">Restaurants</h5>
                                        <ul class="static-list row no-gutters">
                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> James' Kitchen
                                                <br><span class="chef-name">Head Chef:</span> Ching Wen Cheng
                                                <br><span class="special-dish">Speciality dish:</span> Crab Lionhead Meatballs & Fried You Tiao With Oysters
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Shin Yeh <a href="http://www.shinyeh.com.tw/Content/En/About.Aspx" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Zheng Kwun Ying
                                                <br><span class="special-dish">Speciality dish:</span> Three Cup Chicken
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Lan Jia Gua Bao
                                                <br><span class="chef-name">Head Chef:</span> Mr Jack Lan
                                                <br><span class="special-dish">Speciality dish:</span> Gua Boa - "Tiger Bites Pig"
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Ice Monster <a href="http://www.ice-monster.com/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="special-dish">Speciality dish:</span> Avalanches of Shaved Ice
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Hao Chi
                                                <br><span class="chef-name">Head Chef:</span> Mei Chu Tseng
                                                <br><span class="special-dish">Speciality dish:</span> Danzai Noodles
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Dai Lai Xiao Guan
                                                <br><span class="chef-name">Head Chef:</span> Ms Zhang
                                                <br><span class="special-dish">Speciality dish:</span> Braised Pork Rice & Egg and Tomato Stir Fry
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Hot Star Chicken <a href="http://www.hot-star.cn/en/brands/introduction/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="special-dish">Speciality dish:</span> Giant Fried Chicken
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Yong He Dou Jiang Wang
                                                <br><span class="special-dish">Speciality dish:</span> Dan Shaobing You Tiao
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Yuan Huan Bian
                                                <br><span class="chef-name">Head Chef:</span> Mr Lai
                                                <br><span class="special-dish">Speciality dish:</span> Oyster Omlette
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Ning Xia Night Market
                                                <br><span class="special-dish">Speciality dish:</span> Stinky Tofu, Ai Yu Fig Jelly, Taiwanese Sausage Rice, Grilled Cuttlefish Sticks and Lun Piah
                                            </li>

                                        </ul>
                                    </div>



                                    <!-- the okinawa tab -->
                                    <div role="tabpanel" class="tab-content-holder tab-pane fade" id="okinawa">
                                        <div class="row no-gutters">
                                            <div class="col-md-8 col-sm-7 col-12">
                                                <h2 class="static-content-title">Okinawa</h2>
                                                <p class="static-content-text">Okinawa is one of the largest islands off of Japan. The island's population is known as one of the longest living people in the world thanks to them eating plenty of whole grains, vegetables and soy products, as well an abundance of local seafood. It is popular with tourists thanks to its beautiful beaches, parks and the Hiji Falls. It's sub tropical climate fives rise to a diverse range of ingredients on this island. Okinawan cuisine has it's own vibe - an unique mix of Japanese, American and Chinese influences.</p>
                                            </div>
                                            <div class="col-md-4 col-sm-5 col-12">
                                                <img class="img-fluid" src="{{ asset('/images/amazing-asia/ok/ok.jpg') }}" />
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="static-list-title">Restaurants</h5>
                                        <ul class="static-list row no-gutters">
                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Urizun <a href="http://urizun.okinawa/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Shoshin Asato
                                                <br><span class="special-dish">Speciality dish:</span> Banana Fish Tataki, Rabbit Fish Tofu, Dooruten, Hirayachi Pancake, Pepper Ribs, Awamori
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Pork Tamago Onigiri Honten
                                                <br><span class="chef-name">Head Chef:</span> Katsuaki Kiyokawa
                                                <br><span class="special-dish">Speciality dish:</span> Pork and Tamago Onigiri
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Suji Guwa
                                                <br><span class="chef-name">Head Chef:</span> Shoko Takara
                                                <br><span class="special-dish">Speciality dish:</span> Okinawa Soba
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Tacos-Ya
                                                <br><span class="chef-name">Head Chef:</span> Taeko Arime
                                                <br><span class="special-dish">Speciality dish:</span> Taco Rice
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Makishi Kosetsu-ichiba Market
                                                <br><span class="special-dish">Speciality dish:</span> Fresh seafood, Pickles, Sea Grapes, Spam, Fresh Pork
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Honen
                                                <br><span class="chef-name">Head Chef:</span> Toya Higa
                                                <br><span class="special-dish">Speciality dish:</span> Pan fried Tiger Prawns and Local Akamachi Red Snapper
                                            </li>

                                        </ul>
                                    </div>



                                    <!-- the tokyo tab -->
                                    <div role="tabpanel" class="tab-content-holder tab-pane fade" id="tokyo">
                                        <div class="row no-gutters">
                                            <div class="col-md-8 col-sm-7 col-12">
                                                <h2 class="static-content-title">Tokyo</h2>
                                                <p class="static-content-text">Tokyo is the bustling capital city of Japan. It is rich in culture, dining, entertainment and shopping. With an extraordinary amount of cafés and bar as well as excellent museums, gardens and historic temples, there is something for everyone. It's clean, safe with lots of green space both in the city centre and within a short train ride to the outskirts. Here the food is made with meticulous attention and you can sample the freshest and best sushi in the world.</p>
                                            </div>
                                            <div class="col-md-4 col-sm-5 col-12">
                                                <img class="img-fluid" src="{{ asset('/images/amazing-asia/tk/tk.jpg') }}" />
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="static-list-title">Restaurants</h5>
                                        <ul class="static-list row no-gutters">
                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Sushi Kuni
                                                <br><span class="chef-name">Head Chef:</span> Yoshimitsu Kokuba
                                                <br><span class="special-dish">Speciality dish:</span> Tuna Nigiri
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Go Go Curry <a href="http://www.gogocurryusa-ny.com/about.html" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="special-dish">Speciality dish:</span> Katsu Curry & Grand Slam
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Aoba
                                                <br><span class="chef-name">Head Chef:</span> Takayuki Goto
                                                <br><span class="special-dish">Speciality dish:</span> Tsukemen
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Blacows <a href="http://www.kuroge-wagyu.com/bc/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Ryo Fukishima
                                                <br><span class="special-dish">Speciality dish:</span> Wagyu Beef Burgers & Blacows Special
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Tsuna Hachi <a href="https://www.tunahachi.co.jp/en/" target="_blank"><span class="website-address">link here</span></a>
                                                <br><span class="chef-name">Head Chef:</span> Kuwata
                                                <br><span class="special-dish">Speciality dish:</span> Tempura with fresh sea eels and shrimp
                                            </li>

                                            <li class="col-md-6 col-12">
                                                <span class="restaurant-name">Name:</span> Sukiji Market
                                                <br><span class="special-dish">Speciality dish:</span> Biggest fresh seafood market in the world
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>


                        </div><!-- end of .static-page-content -->
                    </div>
                </div>
            </div><!-- end of .row -->
        </div>
    </section>




@endsection




@section('footer-script')
<script type="text/javascript">

    var page = @if(Session::has('page')) "{{ Session::get('page') }}" @else "hongkong" @endif;
    $(document).ready(function() {

        $('#'+page).addClass('active show');
        $('#nav-'+page).addClass('active');

    });

</script>
@endsection