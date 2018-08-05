<?php
Route::get('flush', function () {
    Session::flush();
    Cache::flush();
    setcookie("closeCookie", "", time() - 3600);
});

//Sitemap
Route::get('/sitemap', 'SiteMapController@getSitemap')->name('sitemap');
Route::get('/sitemap-recipe', 'SiteMapController@getSitemapRecipe')->name('SitemapRecipe');
Route::get('/sitemap-video', 'SiteMapController@getSitemapVideo')->name('SitemapVideo');
Route::get('/sitemap-blog', 'SiteMapController@getSitemapBlog')->name('SitemapBlog');

//Index
Route::get('/', 'IndexController@showIndex')->name('index');
Route::get('/search', 'IndexController@getSearch')->name('search');
Route::get('/video-count', 'IndexController@ajaxSetCount')->name('video-count');
Route::get('/ajaxCloseCookieAction', 'IndexController@ajaxCloseCookieAction');


//Static page
Route::get('/individual', 'StaticController@showIndividual')->name('individual');
Route::get('/biography', 'StaticController@showBiography')->name('biography');
Route::get('/lotus-wok', 'StaticController@showLotuswok')->name('lotus-wok');
Route::post('/lotus-wok', 'SubscriptionController@lotuswokSubscribe')->name('lotus-wok');
Route::get('/books', 'StaticController@showBooks')->name('books');
Route::get('/my-story', 'StaticController@showMyStory')->name('my-story');
Route::get('/amazing-asia', 'StaticController@showAmazingAsia')->name('amazing-asia');
Route::get('/privacy-policy', 'StaticController@showPrivacyPolicy')->name('privacy-policy');
Route::get('/terms-and-conditions', 'StaticController@showTermsAndConditions')->name('terms-and-conditions');
Route::get('/contact', 'StaticController@showContact')->name('contact');
Route::post('enquiry', 'StaticController@postEnquiry')->name('enquiry');
Route::get('/cookies', 'StaticController@showCookies')->name('cookies');

//Hyper link for books
Route::get('/books/{bookname?}', 'HyperLinkController@showBookShop')->name('books.shop');

//Subscription
//Route::post('subscription', 'SubscriptionController@emailSubscription')->name('subscription');
Route::get('verify', 'SubscriptionController@verifySubscription')->name('verify');

//Video
Route::get('/videos', 'VideoController@showIndex')->name('all-video');
Route::get('/videos/{series?}', 'VideoController@showVideoSeries')->name('video-series');
Route::get('/videos/{series?}/{slug?}', 'VideoController@showPlayer')->name('video');

Route::get('/video-player/{slug}', function ($slug) {
    $video = \App\Models\Video::where('slug', $slug)->firstOrFail();
    if ($video)
        return redirect()->route('video', ['series' => $video->category()->get()[0]['slug'], 'slug' => $slug], 301);
});

Route::get('/all-video', function () {
    return redirect()->route('all-video', '', 301);
});

//Route::get('/video-data/{slug?}', 'VideoController@getVideoData')->name('video-data');

//Recipes
Route::post('redirectRecipe', 'RecipeController@redirectShowIndex')->name('redirectRecipe');

Route::get('/recipes/search/{course?}/{keyword?}', 'RecipeController@showSearchResult')->name('recipe-search');
Route::get('/recipes/{slug?}/{video?}', 'RecipeController@showRecipeDetails')->name('recipe');

Route::get('/recipe-print/{slug?}/', 'RecipeController@showRecipePrint')->name('recipe-print');
Route::get('/recipe-print-fix/{id?}', 'RecipeController@redirectShowRecipeDetail')->name('recipe-print-fix');

//Blog
Route::get('/blog/rss', 'BlogController@generateRSS')->name('blog-rss');
Route::get('/blog/{cat?}/{slug?}', 'BlogController@showIndex')->name('blog');
Route::get('/blog-details/{slug?}', function ($slug=null) {
    $blog = \App\Models\Blog::queryBySlug($slug)->firstOrFail();
    if ($blog)
        return redirect()->route('blog', ['cat' => $blog->category()->get()[0]['name'], 'slug' => $slug], 301);
})->name('blog_details');

//Routes for guest
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('getForgotPassword');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('forgotPassword');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('resetPassword');
    Route::get('activation/key/{activation_key}', 'Auth\ActivationKeyController@activateKey')->name('activation_key');
    Route::get('activation/resend', 'Auth\ActivationKeyController@showKeyResendForm')->name('activation_key_resend');
    Route::post('activation/resend', 'Auth\ActivationKeyController@resendKey')->name('activation_key_resend');

    Route::post('login', 'Auth\LoginController@login')->name('login');
    Route::post('register', 'Auth\RegisterController@register')->name('register');
    Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook');
    Route::get('facebook/callback', 'Auth\LoginController@handleFacebookCallback');
    Route::get('facebook/complete-sign-up', 'Auth\LoginController@showCompleteFacebookSignUp')->name('complete_facebook_sign_up');
    Route::post('facebook/complete-sign-up', 'Auth\LoginController@completeFacebookSignUp');
});

//Routes for logged in user
Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('profile', 'UserController@showIndex')->name('profile');
    Route::post('profile/personal-information', 'UserController@updateProfile')->name('personalinformation');
    Route::post('profile/change-password', 'UserController@changePassword')->name('profile/change-password');
    Route::post('profile/change-email', 'UserController@changeEmail')->name('profile/change-email');
    Route::post('profile/subscription-setting', 'UserController@updateSubscription')->name('profile/subscription-setting');
    Route::post('profile/change-avatar', 'UserController@changeAvatar')->name('profile/change-avatar');

    Route::post('blog-comment/create/{bid?}', 'BlogCommentController@createComment')->name('comment.create');
    Route::post('blog-comment/delete/{cid?}', 'BlogCommentController@deleteComment')->name('comment.delete');

    //api
    Route::get('video-watched/{slug?}', 'VideoController@videoWatched')->name('video-watched');
});

//admin
Route::group(['middleware' => 'admin','prefix' => 'admin'], function () {
    Route::get('/', 'AdminDashboardController@showIndex')->name('admin');

    Route::get('/blog', 'AdminBlogController@showIndex')->name('adminBlog.index');
    Route::get('/blog/create', 'AdminBlogController@showCreateBlog')->name('adminBlog.create');
    Route::post('/blog/create', 'AdminBlogController@createBlog');
    Route::get('/blog/{id?}', 'AdminBlogController@showEditBlog')->name('adminBlog.edit');
    Route::post('/blog/{id?}', 'AdminBlogController@editBlog');
    Route::get('/blog/delete/{id?}', 'AdminBlogController@deleteBlog')->name('adminBlog.delete');

    Route::get('/users', 'AdminUserController@showIndex')->name('adminUser.index');
    Route::get('/users/{id?}', 'AdminUserController@showEditUser')->name('adminUser.edit');
    Route::post('/users/{id?}', 'AdminUserController@editUser');

    Route::get('/images/{cat?}', 'AdminImageController@showIndex')->name('adminImage.index');
    Route::post('/images/upload', 'AdminImageController@uploadImage')->name('adminImage.upload');
    Route::post('/images/delete/{id?}', 'AdminImageController@deleteImage')->name('adminImage.delete');

    Route::get('/recipes', 'AdminRecipeController@showIndex')->name('adminRecipes.index');
    Route::get('/recipes/create/{step?}', 'AdminRecipeController@showCreateRecipe')->name('adminRecipes.create');
    Route::post('/recipes/create', 'AdminRecipeController@createRecipe');
    Route::post('/recipes/draft', 'AdminRecipeController@createDraftRecipe')->name('adminRecipe.draft');
    Route::get('/recipes/{id?}/{step?}', 'AdminRecipeController@showEditRecipe')->name('adminRecipes.edit');

    Route::get('/recipe-ingredient-section', 'AdminRecipeIngredientSectionController@showIndex')->name('adminRecipeIngredientSection.index');
    Route::get('/recipe-ingredient-section/create', 'AdminRecipeIngredientSectionController@showCreateIngredientSection')->name('adminRecipeIngredientSection.create');
    Route::get('/recipe-ingredient-section/{id?}', 'AdminRecipeIngredientSectionController@showEditIngredientSection')->name('adminRecipeIngredientSection.edit');
    Route::post('/recipe-ingredient-section/{id?}', 'AdminRecipeIngredientSectionController@editIngredientSection');
    Route::get('/recipe-ingredient-section/delete/{id?}', 'AdminRecipeIngredientSectionController@deleteIngredientSection')->name('adminRecipeIngredientSection.delete');

    Route::get('/ingredients', 'AdminIngredientController@showIndex')->name('adminIngredients.index');
    Route::get('/ingredients/create', 'AdminIngredientController@showCreateIngredient')->name('adminIngredients.create');
    Route::get('/ingredients/{id?}', 'AdminIngredientController@showEditIngredient')->name('adminIngredients.edit');
    Route::post('/ingredients/{id?}', 'AdminIngredientController@editIngredient');
    Route::get('/ingredients/delete/{id?}', 'AdminIngredientController@deleteIngredient')->name('adminIngredients.delete');

    Route::get('/ingredient-type', 'AdminIngredientTypeController@showIndex')->name('adminIngredientType.index');
    Route::get('/ingredient-type/create', 'AdminIngredientTypeController@showCreateIngredientType')->name('adminIngredientType.create');
    Route::get('/ingredient-type/{id?}', 'AdminIngredientTypeController@showEditIngredientType')->name('adminIngredientType.edit');
    Route::post('/ingredient-type/{id?}', 'AdminIngredientTypeController@editIngredientType');
    Route::get('/ingredient-type/delete/{id?}', 'AdminIngredientTypeController@deleteIngredientType')->name('adminIngredientType.delete');

    Route::get('/edm', 'AdminRegularEDMController@showIndex')->name('adminEdm.index');
    Route::get('/edm/delete/{id?}', 'AdminRegularEDMController@deleteEDM')->name('adminEdm.delete');
    Route::get('/edm/preview/{id?}', 'AdminRegularEDMController@previewEDM')->name('adminEdm.preview');
    Route::get('/edm/send/{id?}', 'AdminRegularEDMController@showSendEDM')->name('adminEdm.send');
    Route::get('/edm/create', 'AdminRegularEDMController@showCreateEDM')->name('adminEdm.create');
    Route::get('/edm/{id?}', 'AdminRegularEDMController@showEditEDM')->name('adminEdm.edit');
    Route::post('/edm/send/test', 'AdminRegularEDMController@sendTestEDM')->name('adminEdm.send.test');
    Route::post('/edm/send', 'AdminRegularEDMController@sendEDM');
    Route::post('/edm/{id?}', 'AdminRegularEDMController@editEDM');

    Route::get('/newsletter', 'AdminNewsletterController@showIndex')->name('adminNewsletter.index');
    Route::get('/newsletter/delete/{id?}', 'AdminNewsletterController@deleteNewsletter')->name('adminNewsletter.delete');
    Route::get('/newsletter/preview/{id?}', 'AdminNewsletterController@previewNewsletter')->name('adminNewsletter.preview');
    Route::get('/newsletter/send/{id?}', 'AdminNewsletterController@showSendNewsletter')->name('adminNewsletter.send');
    Route::get('/newsletter/create', 'AdminNewsletterController@showCreateNewsletter')->name('adminNewsletter.create');
    Route::get('/newsletter/{id?}', 'AdminNewsletterController@showEditNewsletter')->name('adminNewsletter.edit');
    Route::post('/newsletter/send/test', 'AdminNewsletterController@sendTestNewsletter')->name('adminNewsletter.send.test');
    Route::post('/newsletter/send', 'AdminNewsletterController@sendNewsletter');
    Route::post('/newsletter/{id?}', 'AdminNewsletterController@editNewsletter');

    Route::post('/blog-comment/spam/{cid?}', 'BlogCommentController@spamComment')->name('comment.spam');

    Route::get('/log', 'AdminDashboardController@getLog')->name('admin-log');
});

Route::get('/edm-image/{uid?}/{edmId?}', 'AdminRegularEDMController@edmWatchCount')->name('edm.gen.image');
Route::get('/newsletter-image/{uid?}/{newsletterId?}', 'AdminNewsletterController@newsletterWatchCount')->name('newsletter.gen.image');
//temp fix for old site link
Route::get('/recipe-details/{slug?}', function ($slug=null) {
    return redirect()->route('recipe', ['slug'=>$slug], 301);
});
Route::get('/page/{page?}/{params?}', function ($page = null) {
    switch ($page) {
        case "forum_post":
        case "promotions":
        case "kitchen":
            return Redirect::to('/', 301);
            break;
        case "register":
        case "signupclickandcook":
            return Redirect::to('/#register', 301);
            break;
        case "userlogin":
        case "clickandcooklogin":
            return Redirect::to('/#login', 301);
            break;
        case "video":
            return redirect()->route('all-video', '', 301);
            break;
        case "contacts":
            return redirect()->route('contact', '', 301);
            break;
        case "recipes":
        case "showrecipe":
            return redirect()->route('recipe', '', 301);
            break;
        case "books":
            return redirect()->route('books', '', 301);
            break;
        case "blog":
        case "blog-index":
        case "showblog":
        case "photos":
        case "archive":
            return redirect()->route('blog', '', 301);
        case "charity":
        case "showcharity":
            return redirect()->route('blog', "Charity", 301);
            break;
        case "news":
            return redirect()->route('blog', "News", 301);
            break;
        case "lotuswok":
            return redirect()->route('lotus-wok', '', 301);
            break;
        case "bio":
        case "awards":
        case "tvshows":
        case "press":
            return redirect()->route('biography', '', 301);
            break;
        case "tandc":
            return redirect()->route('terms-and-conditions', '', 301);
            break;
        case "amazingasia":
            return redirect()->route('amazing-asia', '', 301);
            break;
        default:
            return redirect()->route('index', '', 301);
            break;
    }
})->where('params', '(.*)');

Route::any('{all}', function () {
    abort(404);
})->where('all', '.*');