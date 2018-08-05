@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | Books | ChingHeHuang.com')
@section('page-description', 'Centered on fresh, ethically sourced ingredients, Chinese heritage and modern flavours, Ching\'s books make Chinese cooking easy, healthy and delicious. Wok on!') {{-- Defaults --}}
@section('fb-ref-image', config('app.url') . '/images/carousel/books.jpg')
@section('header-script')

@endsection



@section('content')

    <section class="offset-top bg-color white">
        <div class="container-fluid p0">
            <div class="row no-gutters">
                <div class="col">
                    <div class="full-image-holder smaller"
                         style="background-image: url('{{ asset('/images/carousel/books.jpg') }}');">
                        <div class="image-text-overlay">
                            <h1 class="text-overlay-title">Shop Ching's Books</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-color white">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-10 col-12 offset-lg-1">


                    <!-- book 2 -->
                    <div class="row book-holder mb40 mt40">
                        <div class="col-sm-4 col-12 push-sm-8 mb-xs-24 text-center">
                            <img class="img-fluid"
                                 src="{{ asset('/images/books/stir-crazy-blurb.jpg') }}"/>
                            {!! \App\Models\RecipeSource::find(12)->getLink(true) !!}
                        </div>
                        <div class="col-sm-8 col-12 pull-sm-4">
                            <h3 class="text-color main mb24">Stir Crazy: 100 deliciously healthy stir-fry recipes</h3>
                            <p class="small-90">
                                I am obsessed with Stir Fries – you could say a bit ‘crazy’ about them. And why not? Stir-frying is not only quick and easy, it also requires very little equipment – all you need is a wok, a knife and a chopping board!<br><br>
                                In this book, I teach you what differentiates a good stir-fry from a great one! It’s not always so easy to master and it is not about throwing all the ingredients in at once and hoping for the best! Indeed, it is all about timing, knowing when to add what and how to get the best out of each ingredient to get that crisp finish and smokey ‘wok hei’ flavour that Chinese masters are mad about!<br><br>
                                In Stir Crazy, I have gathered together a collection of delicious stir-fry recipes for busy people, dishes that are simple enough for everyday healthy cooking at home, with nutrition, taste, affordability and balance in mind.<br><br>
                                With tips on controlling the heat, to choosing the right oils, I focus on simple preparation so if you have little or no cooking experience – you will be well on your way! Or if you are a foodie, there’s plenty of wok inspiration for you. Many of the recipes are gluten and dairy free, as well as suitable for vegans and vegetarians, and include both Asian and Western ingredients readily available in any supermarket.<br><br>
                                So whether or not you eat meat, love carbs or prefer to avoid them, want something special or find yourself having to feed your family in a hurry, all you need to do is pick up this book and my Lotus wok of course!
                            </p>
                        </div>
                    </div>
                    <hr>


                    <!-- book 1 -->
                    <div class="row book-holder mb40 mt40">
                        <div class="col-sm-4 col-12 mb-xs-24 text-center">
                            <img class="img-fluid"
                                 src="{{ asset('/images/books/Eat-Clean-Wok-Yourself-to-Health.jpg') }}"/>
                             {{--<a href="{{ route('books.shop', 'eat-clean-wok-yourself-to-health') }}" target="_blank" class="button-in-light text-uppercase mt24">Buy now</a>--}}
                            {!! \App\Models\RecipeSource::find(9)->getLink(true) !!}
                        </div>
                        <div class="col-sm-8 col-12">
                            <h3 class="text-color main mb24">Eat Clean: Wok Yourself to Health</h3>
                            <p class="small-90">
                                Eat Clean: Wok Yourself to Health is a revolutionary East-West approach to eating well.
                                The
                                recipes embrace natural produce, cooked simply. It is about choosing the right foods,
                                adopting
                                easy to follow techniques to cook dishes that can help detoxify and nourish the body.
                                The
                                recipes are to serve 1 - and each recipe has been measured for Calories, Protein, Carbs,
                                Sugars,
                                Fat, Sat Fat, Fibre, Sodium. This is good for anyone wanting to change their eating
                                habits and
                                following a healthier lifestyle. The recipes are 80% vegetables, 20% meat or fish and I
                                advocate
                                buying organic where possible and to cut out high sugar, high caffeine, overly processed
                                food
                                ingredients. I advocate using simple fresh ingredients and a more mindful approach to
                                eating.
                                Readers will be able to cook simple healthy delicious recipes with flavour - I have
                                something
                                for everyone - for breakfast, lunch and dinner. I fuse Chinese health efficacies of
                                yin-yang
                                combined with western nutritional practices to bring a east-west approach to eating
                                well, in
                                simple terms, the combination of raw and stir fried foods to achieve a balanced way of
                                eating.
                            </p>
                        </div>
                    </div>
                    <hr>

                    <!-- book 2 -->
                    <div class="row book-holder mb40 mt40">
                        <div class="col-sm-4 col-12 push-sm-8 mb-xs-24 text-center">
                            <img class="img-fluid"
                                 src="{{ asset('/images/books/Exploring-China-A-Culinary-Adventure-100-recipes-from-our-journey.jpg') }}"/>
{{--                            <a href="{{ route('books.shop', 'exploring-china-a-culinary-adventure-100-recipes-from-our-journey') }}" target="_blank" class="button-in-light text-uppercase mt24">Buy now</a>--}}
                            {!! \App\Models\RecipeSource::find(8)->getLink(true) !!}
                        </div>
                        <div class="col-sm-8 col-12 pull-sm-4">
                            <h3 class="text-color main mb24">Exploring China: A Culinary Adventure: 100 Recipes from Our
                                Journey</h3>
                            <p class="small-90">
                                I'm very excited about this new book with Ken Hom that is published by BBC Books.
                                Exploring China: A Culinary Adventure accompanies a 4-part BBC 2 TV series, for which
                                the transmission date will be announced soon – watch this space!
                                <br>It was no easy task to create this book, Ken and I journeyed through China on a
                                culinary and cultural odyssey to find the old, the new and the unexpected – and we found
                                plenty of each!
                                <br>We arrived in Beijing to explore the influences of the West on traditional Imperial
                                cuisine and met cutting-edge chefs who cooked up riverside snacks in Yunnan. We
                                discovered the influence of Buddhism on vegetarian food and went right to the boundaries
                                of Chinese food and culture in remote Kashgar before travelling to Sichuan Province,
                                China's gastronomic capital. Phew! A long, but very enlightening, journey indeed.
                                <br>The book has 100 recipes and beautiful food and location photography – some of the
                                places really were stunning. There are also features on China's regional cuisines and
                                cultures and recipes we personally gathered from our journey.
                            </p>
                            <p class="small-90">Recipes include:</p>
                            <ul class="small-90">
                                <li>Seabass, baby pak choi and coriander soup</li>
                                <li>Spicy Sichuan noodles</li>
                                <li>Stir-fried crab with ginger and spring onions</li>
                                <li>Tea smoked Sichuan Duck</li>
                                <li>Crossing the bridge Noodles</li>
                                <li>Lotus Roots and Woodear fungus</li>
                                <li>Yunnan style steamed sea bream</li>
                                <li>DoFu Casserole</li>
                                <li>Mala Braised beef shank</li>
                                <li>Smoked La-Rou Pork with sweetcorn</li>
                            </ul>
                            <p class="small-90">Ken and I bring a unique perspective on Chinese Food and this really is
                                our homecoming, as we make their own pilgrimages to Canton and Taiwan to discover our
                                personal and culinary roots.
                                <br><br>I hope you enjoy the book – happy wokking!
                                <br><br>Much love, Ching x
                            </p>
                        </div>
                    </div>
                    <hr>

                    <!-- book 3 -->
                    <div class="row book-holder mb40 mt40">
                        <div class="col-sm-4 col-12 mb-xs-24 text-center">
                            <img class="img-fluid"
                                 src="{{ asset('/images/books/Chings-Fast-Food-110-Quick-and-Healthy-Chinese-Favourites.jpg') }}"/>
{{--                            <a href="{{ route('books.shop', 'chings-fast-food-110-quick-and-healthy-chinese-favourites') }}" target="_blank" class="button-in-light text-uppercase mt24">Buy now</a>--}}
                            {!! \App\Models\RecipeSource::find(6)->getLink(true) !!}
                        </div>
                        <div class="col-sm-8 col-12">
                            <h3 class="text-color main mb24">Ching's Fast Food: 108 Quick and Healthy Chinese
                                Favourites</h3>
                            <p class="small-90">
                                CHING'S FAST FOOD provides you with a new and exciting dimension to Chinese cooking.
                                There are 110 delicious, quick and easy dishes bursting with flavour - this is my fresh
                                and healthy take on the Chinese takeaway, which I hope will revolutionise Chinese
                                cuisine by removing the stigma attached to the humble takeaway.
                            </p>
                            <p class="small-90">
                                I've included some of my most memorable childhood experiences, intertwined with Chinese
                                superstition, etiquette and original suggestions for exciting variations on classic
                                recipes. The book will take you on a culinary journey, from the traditional Chicken Chow
                                Mein to the more adventurous Cantonese-style steamed Lobster with Ginger Soy Sauce.
                                Lighter dishes such as Yellow Bean Sesame Spinach offer a diverse selection of new and
                                delicious recipes for every occasion and taste and I hope will inspire even the most
                                stalwart takeaway devotees to get cooking.
                            </p>
                            <p class="small-90">
                                Please note this is the UK edition of Ching's Everyday Easy Chinese.
                            </p>
                        </div>
                    </div>
                    <hr>

                    <!-- book 4 -->
                    <div class="row book-holder mb40 mt40">
                        <div class="col-sm-4 col-12 push-sm-8 mb-xs-24 text-center">
                            <img class="img-fluid"
                                 src="{{ asset('/images/books/bookusa1.jpg') }}"/>
{{--                            <a href="{{ route('books.shop', 'chings-everyday-easy-chinese') }}" target="_blank" class="button-in-light text-uppercase mt24">Buy now</a>--}}
                            {!! \App\Models\RecipeSource::find(7)->getLink(true) !!}
                        </div>
                        <div class="col-sm-8 col-12 pull-sm-4">
                            <h3 class="text-color main mb24">Ching's Everyday Easy Chinese</h3>
                            <p class="small-90">
                                Out on the 4th October 2011, in Everyday Easy Chinese, I fuse Chinese and Western
                                cultures to create one hundred quick dishes full of natural ingredients and bursting
                                with flavor. Everyday Easy Chinese makes it simple for home cooks to prepare their
                                favorite Chinese dishes faster, cheaper, and more healthily than their local restaurant.
                                Enjoy a diverse selection of favorite recipes for every occasion and taste, including:
                            </p>
                            <p class="small-90">Recipes include:</p>
                            <ul class="small-90">
                                <li>Traditional Hot and Sour Soup</li>
                                <li>Five-Spice Salted Shrimp with Hot Cilantro Sauce</li>
                                <li>Crispy Sweet Chili Beef Pancakes</li>
                                <li>Kung Po Chicken</li>
                                <li>Black Pepper Beef and Rainbow Vegetable Stir-Fry</li>
                                <li>Singapore Noodles</li>
                                <li>Egg and Asparagus Fried Rice</li>
                            </ul>
                            <p class="small-90">Interspersed with entertaining personal stories and suggestions for
                                exciting variations on classic recipes, Ching's Everyday Easy Chinese will take you on a
                                culinary journey that delightfully blends ancient and modern, yin and yang,
                                experimentation and intuition - and ends with perfectly balanced and tantalizing fare
                                that will inspire even the most stalwart takeout devotees.
                                <br><br>Please note this is the US edition of Ching's Fast Food.
                            </p>
                        </div>
                    </div>
                    <hr>

                    <!-- book 5 -->
                    <div class="row book-holder mb40 mt40">
                        <div class="col-sm-4 col-12 mb-xs-24 text-center">
                            <img class="img-fluid"
                                 src="{{ asset('/images/books/Chings-Chinese-Food-in-Minutes.jpg') }}"/>
{{--                            <a href="{{ route('books.shop', 'chings-chinese-food-in-minutes') }}" target="_blank" class="button-in-light text-uppercase mt24">Buy now</a>--}}
                            {!! \App\Models\RecipeSource::find(10)->getLink(true) !!}
                        </div>
                        <div class="col-sm-8 col-12">
                            <h3 class="text-color main mb24">Ching’s Chinese Food in Minutes</h3>
                            <p class="small-90">
                                If you're hungry for good food but short on time I hope this is the book you'll love. I
                                am a believer of fresh flavours and simple ingredients and my collection of all-time
                                favourites and exciting new dishes are waiting for you to cook and share. Why order a
                                take-away when you can deliver your own in minutes?
                            </p>
                            <p class="small-90">
                                While I was writing Chinese Food Made Easy, there were so many recipes I wanted to
                                include but couldn't. So I have collected and compiled them in this book and it is
                                packed with quick and easy recipes that you can make in 30 minutes or less. You can make
                                all the delicious healthy recipes nearly always with everyday supermarket ingredients.
                            </p>
                            <p class="small-90">
                                My recipes are as varied and I've tried to balance my all-time favourites, such as Sweet
                                and Sour Pork, Chicken and Cashew Nut Stir-fry and Hot and Sour Soup, with exciting new
                                authentic dishes such as Exploding River Prawns, Hunan-style Hot Pink Pepper Chicken and
                                Chongqing Beef. For more special days when you have a little more time on your hands
                                there is an Easy Entertaining section complete with menu suggestions and time-saving
                                tips.
                            </p>
                            <p class="small-90">
                                I really hope this new book will inspire you to cook Chinese and give you new fresh
                                ideas whether you are a beginner or a professional. I hope will find it handy when you
                                need to base your cooking around the time available!
                            </p>
                        </div>
                    </div>
                    <hr>

                    <!-- book 6 -->
                    <div class="row book-holder mb40 mt40">
                        <div class="col-sm-4 col-12 push-sm-8 mb-xs-24 text-center">
                            <img class="img-fluid"
                                 src="{{ asset('/images/books/dvd01.jpg') }}"/>
                            <a href="{{ route('books.shop', 'chinese-food-made-easy') }}" target="_blank" class="button-in-light text-uppercase mt24">Buy now</a>
                        </div>
                        <div class="col-sm-8 col-12 pull-sm-4">
                            <h3 class="text-color main mb24">Chinese Food Made Easy</h3>
                            <p class="small-90">
                                DVD - Chinese Food Made Easy as seen on BBC2.
                            </p>
                            <p class="small-90">
                                In this DVD I demonstrate how to prepare classic Chinese dishes, modernising them with
                                fresh, easy to buy ingredients, as well as offering instructions on the key elements of
                                preparation and cooking and simple techniques and tips. Throughout the series I am set
                                real on-location cooking challenges and take cameras behind the scenes at imaginative
                                and exciting events at which I cook dishes including a celebration of Chinese New Year
                                for family and friends and a farewell meal for Olympic hopefuls bound for the Beijing
                                Olympics 2008. I also introduce legends, traditions and mythology, explaining the place
                                of food in Chinese life, the Yin and Yang of menus and the spiritual and medicinal
                                properties of foods. Come and follow me on this food journey across UK!
                            </p>
                            <p class="small-90">
                                Episode 1: Takeaway Favourites<br>
                                Episode 2: Street Food<br>
                                Episode 3: Seafood<br>
                                Episode 4: Noodles and Dim Sum<br>
                                Episode 5: Spicy Sichuan<br>
                                Episode 6: Cooking for family and friends
                            </p>
                        </div>
                    </div>
                    <hr>

                    <!-- book 7 -->
                    <div class="row book-holder mb40 mt40">
                        <div class="col-sm-4 col-12 mb-xs-24 text-center">
                            <img class="img-fluid"
                                 src="{{ asset('/images/books/Chinese-Food-Made-Easy-100-simple-healthy-recipes-from-easy-to-find-ingredients.jpg') }}"/>
{{--                            <a href="{{ route('books.shop', 'chinese-food-made-easy-100-simple-healthy-recipes-from-easy-to-find-ingredients') }}" target="_blank" class="button-in-light text-uppercase mt24">Buy now</a>--}}
                            {!! \App\Models\RecipeSource::find(5)->getLink(true) !!}
                        </div>
                        <div class="col-sm-8 col-12">
                            <h3 class="text-color main mb24">Chinese Food Made Easy: 100 simple, healthy recipes from
                                easy-to-find ingredients</h3>
                            <p class="small-90">
                                I love this book and I loved working on the TV show. I was challenged to re-invents the
                                nation's favourite Chinese dishes, modernising them with fresh, easy-to-buy ingredients
                                to demonstrate how healthy, light and simple Chinese cooking can be - it was certainly a
                                challenge and loads of fun. Some of the recipes were inspired by my cooking experiences
                                with the British public from all walks of life with a passion for good produce and
                                delicious Chinese food.
                            </p>
                            <p class="small-90">
                                The recipes from my BBC TV series, Chinese Food Made Easy, are included in eight
                                chapters (with over 100 recipes and ideas) ranging from Take away Favourites, Spicy
                                Sichuan dishes, and Dumplings, Dim Sum and Noodles to Fish and Seafood dishes, Street
                                Food, Celebration Food, Desserts and Drinks and Side dishes.
                            </p>
                            <p class="small-90">
                                Throughout the book I've included cooking tips and basic techniques, including all you
                                need to know about using a wok. As with all cooks, we all need some inspiration and I've
                                included some of my stories and recipes collected from my trips to China so I've tried
                                to share a bit of Chinese culture too. I also devised a menu planned to help you make it
                                easy to put together an authentic Chinese meal and I hope you will find these authentic,
                                hassle-free dishes a joy to make in your own kitchen.
                            </p>
                        </div>
                    </div>
                    <hr>

                    <!-- book 8 -->
                    <div class="row book-holder mb40 mt40">
                        <div class="col-sm-4 col-12 push-sm-8 mb-xs-24 text-center">
                            <img class="img-fluid"
                                 src="{{ asset('/images/books/China-Modern-100-Cutting-edge-Fusion-style-Recipes-for-the-21st-Century.jpg') }}"/>
{{--                            <a href="{{ route('books.shop', 'china-modern-100-cutting-edge-fusion-style-recipes-for-the-21st-century') }}" target="_blank" class="button-in-light text-uppercase mt24">Buy now</a>--}}
                            {!! \App\Models\RecipeSource::find(4)->getLink(true) !!}
                        </div>
                        <div class="col-sm-8 col-12 pull-sm-4">
                            <h3 class="text-color main mb24">China Modern: 100 Cutting-edge, Fusion-style Recipes for
                                the 21st Century</h3>
                            <p class="small-90">
                                "CHINA MODERN" -Modern Chinese food has come a long way from the traditional favourites
                                that we order by rote from our local takeaway. As China opens up to the West as well as
                                the rest of the East, its culinary traditions have evolved to create a new and exciting
                                cuisine that can best be described as fusion.
                            </p>
                            <p class="small-90">
                                In "China Modern", I explore these new influences and challenge conventional perceptions
                                of Chinese food. I look at how dishes have been reinvented, drawing on inspiration from
                                Japan, Thailand and Vietnam as well as Europe.
                            </p>
                            <p class="small-90">
                                My 'Peking Duck Sushi', for example, fuses a traditional Chinese dish with classic
                                Japanese presentation, while my 'Steamed Sea bass with Stir Fried Spring Onions and
                                Chillies' demonstrates the breadth of cooking style in regional China. Healthy eating
                                has also become more important and cooking techniques are moving away from deep-frying
                                to steaming, pan-frying, boiling, grilling and even baking!
                            </p>
                            <p class="small-90">
                                I share some home cooked dishes from the less well-known provinces in China such as
                                Hunan and Sichuan (most of the food we know as Chinese originated in Hong Kong) as well
                                as how those takeaway favourites can be cooked at home. "China Modern" traces an
                                exciting culinary journey; one that I hope you will explore with me!
                            </p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>



@endsection




@section('footer-script')

@endsection