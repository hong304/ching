@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | My Story | ChingHeHuang.com')
@section('page-description','Learn all about Ching\'s unconventional journey of becoming an international TV chef and how her family has been an inspiration for her career success!')
@section('fb-ref-image', config('app.url') . '/images/my-story/ching_header_image.jpg')
@section('header-script')

@endsection



@section('content')

    <section class="offset-top bg-color white">
        <div class="container-fluid p0">
            <div class="row no-gutters">
                <div class="col">
                    <div class="full-image-holder text-center" id="my-story-header">
                        <h1 class="story-title">My Story</h1>
                        <img class="img-fluid" src="{{ asset('/images/my-story/ching_header_image.jpg') }}" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="offset-top bg-color white mt-xs-0">
        <div class="container mb40">
            <div class="row no-gutters">
                <div class="col-12">
                    <div class="text-left">
                        <div class="static-page-content standard-padding" id="my-story">
                            <div class="row">
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0">
                                    <h1 class="static-content-title">How I became a TV Chef</h1>
                                    <p class="small">Written by Ching He Huang</p>
                                </div>
                            </div>


                            <div class="row mb40 mb-xs-16">
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture1.jpg') }}" />
                                    <p class="small photo-caption">Me, aged 5, on my grandmothers farm in Pai He, Tainan, Taiwan.</p>
                                </div>
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0">
                                    <p class="static-content-text">There were a series of defining moments in my life that I think led me to TV cookery.
                                        <br><br>
                                        My very first Zong-zi (bamboo wrapped sticky rice dumpling) that my grandmother taught me to ‘make’ was when I was five, sitting on her knee on our farm in Taiwan. I think my grandmother secretly groomed me to be a cook. I grew up watching her at cook for all my extended family – all 25 of them! We would usually all feast together in the large open courtyard or in our dining room in our dwelling. I use the word ‘feast’ loosely; meals were humble and from the farm.</p>
                                </div>
                            </div>


                            <div class="row mb40 mb-xs-16">
                                <div class="col-lg-4 col-sm-8 col-12 offset-lg-4 offset-sm-2 offset-0">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture2.jpg') }}" />
                                    <p class="small photo-caption">My grandmothers dining room on our Chinese farm courtyardhouse in Pai He, Tainan.</p>
                                </div>
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0">
                                    <p class="static-content-text">She mastered the wok like no other. In our humble farm courtyard Siheyuan, she fed us everyday.  My brother and I would always get an egg in the morning, we had congee pretty much everyday with her homemade soy cucumber pickles, roasted salted red peanuts in the shell (that she would roast in her gigantic wok set on wood fired stove), and not forgetting dried shrimp floss or dried pork floss with spring onions and the occasional seaweed or woodear and tofu pickle.</p>
                                    <p class="static-content-text">Sometimes, for a treat, she would get the freshly made beancurd off a lady who would cycle by selling silky beancurd with hot cane syrup and that would be our treat. Lunch would usually be fried rice using the day’s leftovers with some winter melon soup. Dinner was more of a more elaborate affair with some more dishes like stewed soy pork trotters, steamed carp with salted pickled “you-cai” (a kind of Taiwanese olive), salted turnip egg omelette, stir fried vegetables in garlic (whatever was from the garden – sweet potato leaves, pea shoots or spinach), and of course soup – a gigantic bowl of seasonal soup broth with bamboo shoots and sometimes pork bones. All this was served with plain Taiwanese short grain rice.                            </p>
                                    <p class="static-content-text">I never remembered her complaining, she cooked everyday.  She did it with style and glamour as much as she could afford. She loved to put her hair in rollers, wear Qipao skirt pants and wear bright red lipstick. She was obsessed with Ponds face cream and later Lancôme would become her obsession. She was truly a remarkable woman.</p>
                                </div>
                            </div>


                            <div class="row mb40 mb-xs-16">
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture3.jpg') }}" />
                                    <p class="small photo-caption">My grandmother top far left in a mini dress.</p>
                                </div>
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0">
                                    <p class="static-content-text">Then in 1984, my father moved us to South Africa. My father had by chance met a South African businessman (Uncle Robert) and started helping him import bicycles made in Taiwan to South Africa, as that was the cheapest mode of transport.  My mother took us to visit the only one Chinese supermarket in Joburg every Saturday so she could get her supplies of tinned abalone and rice wine, it meant that I spent almost every weekend in a Chinese supermarket helping mum search for her ingredients. I didn’t complain because every visit meant mouth-watering lunchboxes at school the following week, which made all my friends enviable. Aunty Susan (Uncle Robert’s wife) introduced us to yoghurt (which we had never had in Taiwan before) and Avocado on toast, and this was back in 1984! My mum then put a fried egg and soy sauce on top and that was our breakfast almost everyday. It was even fashionable back then.</p>
                                </div>
                            </div>


                            <div class="row mb40 mb-xs-16">
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture4.jpg') }}" />
                                    <p class="small photo-caption">Immigrants abroad – On Uncle Robert & Aunty Susan’s Farm (during Apartheid 1984) </p>
                                </div>
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0">
                                    <p class="static-content-text">A few years later, another move, this time to the U.K. when I was eleven in 1989. This change pushed my culinary experiences further than ever...financial circumstances took my mother to work back in Taiwan whilst my father stayed with my brother and I to finish schooling.</p>
                                    <p class="static-content-text">Now, my father was a terrible cook! He could make rice and fried eggs, so I was trained by my mother to cook for him before she would travel abroad each time. Cooking was fun at first, then started to become a chore and a burden, so whilst my cooking skills improved – from watery fried rice to the proper stuff, my love for cooking declined.</p>
                                    <p class="static-content-text">My passion for cooking was reignited when my mother finally returned to London in 1999 and when I was about to graduate from university, I had a decision to make – either work in a bank in the city or find something else. I couldn’t think of anything worse than working for a bank, so I decided to start a catering company. During the finals of my exams I went hunting for clients. I approached Prêt, Benjy’s, and Europa Foods. I was unsuccessful with Prêt but started with Europa and then Benjy’s. From £500, a phone call to the buyer, labels from Kall Kwik, ingredients & bento box packaging from Wing Yip, my homemade “cool noodle” salad samples were created and Fuge Ltd. was born.</p>
                                </div>
                            </div>



                            <div class="row mb40 mb-xs-16">
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0 mb16">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture6.jpg') }}" />
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture5.jpg') }}" />
                                </div>
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0">
                                    <p class="static-content-text">Miraculously, everything fell into place. I didn’t have money for refrigerated vehicles but in the last hour a distributor opposite my rental kitchens (which I haggled for 3 months free rent), meant my business was green lit. Orders came in via fax, I was working 7 days a week 16 hour days, taking the tube to canvas for new customers in the form of fast food chains, cafes and restaurants, returning, at midday to make the food ready for my distributor to send out by midnight for delivery into stores the next day.</p>
                                    <p class="static-content-text">This was my life for 3 years non-stop. Gradually I employed more and more staff as the orders grew. I went on to develop Asian wraps, fresh Ramen Cup Noodles, So-Ya! (Fresh Soya milk drinks that were stocked in 30 Waitrose stores, and then got de-listed as the flavour was “too beany” “too Chinese in taste” and this was before the Alpro guys came in). I also went on to develop my own brand of vinegar drinks called TZU. It was a crazy whirlwind experience. I had never worked so hard in my life and I hadn’t even reached 25 yet!</p>
                                </div>
                            </div>



                            <div class="row mb40 mb-xs-16">
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0 mb16">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture7.jpg') }}" />
                                </div>
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0">
                                    <p class="static-content-text">It was whilst cooking and running my food business I met my now husband. His sister was working for UK Food as a press officer. She said I needed PR - I didn’t know what PR meant but she was looking to secure a house deposit so we struck a deal – she would help me PR and I would try it for 6 months!</p>
                                    <p class="static-content-text">She suggested I go into UK Food with a bag of my meals and try persuading the commissioning executive to let me go on their flagship show, Great Food Live, where chefs cook live on the show. I was given a screen test, which I passed, and the opportunity to cook on TV. The first show was nerve-wracking but went well. The producers kept asking me back – it was incredibly rewarding (not financially, as TV doesn’t pay well) but it gave me a sense of achievement.</p>
                                    <p class="static-content-text">Trying to create and sell food to buyers can be disheartening, especially when creatively you are constrained by budgets of £1.50 per meal!</p>
                                </div>
                            </div>



                            <div class="row mb40 mb-xs-16">
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0 mb16">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/food-picture.jpg') }}" />
                                </div>
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0">
                                    <p class="static-content-text">TV was a breath of fresh air for my cooking and creativity. It allowed me to share my creations without any constraints, especially as the TV producers were so supportive of my food. I fell in love with food again; it was no longer a chore, a necessity, and it became a true passion.</p>
                                    <p class="static-content-text">For 5 years I was juggling two careers as the same time – running my food business whilst writing books and appearing on TV shows. For most of the time I was stressed out and tired but never felt so alive. In 2009, after 10 years, I decided to close my food business and concentrate on books and TV. It was a hard decision at first but having dedicated all my twenties to food production, I was burnt out. Deep down I knew it was the freedom to create and share recipes that inspired me and not managing a food business, which was what my role in my business had become.</p>
                                    <p class="static-content-text">However, that freedom has led me to amazing experiences, from developing recipes for restaurant owners, to starring in my own TV shows to developing my own products to receiving an Emmy nomination for one of my shows in America.</p>
                                </div>
                            </div>




                            <div class="row mb40 mb-xs-16">
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0 mb16">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/offer/AmazingAsia_PreTitles_Still.jpg') }}" />
                                </div>
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0 mb16">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture22.jpg') }}" />
                                    <p class="small photo-caption">Emmy Nomination, Beverly Hills (2013)</p>
                                </div>
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0 mb16">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture23.jpg') }}" />
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture24.jpg') }}" />
                                    <p class="small photo-caption">Conducted the Food Tour for HRH in London Chinatown (2007)</p>
                                </div>
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0 mb16">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture25.jpg') }}" />
                                    <p class="small photo-caption">Demonstrating how to make Xiaolongbao for Duchess of Cornwall at Dumplings Legends London Chinatown (2015)</p>
                                </div>
                                <div class="col-lg-10 col-12 offset-lg-1 offset-0">
                                    <p class="static-content-text">My biggest inspiration in my life and career has been my family, especially my grandmother and mother. Knowing the sacrifices they made in order to give us a better a life makes me appreciate all that they gave and makes me strive for better.</p>
                                    <p class="static-content-text">A wise fortune cookie once revealed – hard work beats talent if talent doesn’t work hard. That keeps me grounded.</p>
                                    <p class="static-content-text">As you can see, my personal route and journey into TV cooking was an unconventional one. I believe there are no rules to achieving one’s dreams; all journeys are individual, shaped by our own experiences and perceptions. It does take a lot of hours of dedication and mental focus to get there, but trust and allow yourself to explore your own abilities, let yourself try new things, and have the courage to tackle your fears straight on.</p>
                                    <p class="static-content-text">The quality of your life and goals depends on the quality of your thoughts so positive thinking is crucial. We all have self-doubt but life is short and we only get one life to achieve what we want. The personal rewards are greater than any material gain. The sense of achievement is worth all the blood, sweat, tears and even the varicose veins!</p>
                                    <p class="static-content-text">For anyone wanting to follow a career in food and media, I suggest you go for it! Whatever you do, throw yourself in the deep-end, it’s the best way to learn.</p>
                                    <p class="static-content-text">I wish you much success in your journey and happy healthy wokking!
                                        <br><br><i class="fa fa-heart-o" aria-hidden="true"></i> Love,
                                        <br>Ching
                                    </p>
                                </div>
                                <div class="col-lg-6 col-sm-8 col-12 offset-lg-3 offset-sm-2 offset-0 mb16">
                                    <img class="img-fluid image-inside-content" src="{{ asset('/images/my-story/Picture26.jpg') }}" />
                                </div>
                            </div>




                            <div class="clear-float"></div>
                        </div><!-- end of .static-page-content -->

                    </div>
                </div>

            </div><!-- end of .row -->
        </div>
    </section>


@endsection


@section('footer-script')

@endsection