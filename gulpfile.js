const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
        .sass('admin.scss')
        .webpack('app.js')
        .webpack('croppie.js')
        .webpack('masonry.js')
        .webpack('video.js')
        .webpack('sortable.js')
        //The scripts method assumes all paths are relative to the resources/assets/js directory, and will place the resulting JavaScript in public/js/all.js by default:
        .scripts(['custom.js'])
        .version(['css/app.css','css/admin.css','js/app.js']);
});