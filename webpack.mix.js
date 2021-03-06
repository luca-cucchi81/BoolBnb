const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin/show.js', 'public/js/admin')
    .js('resources/js/admin/sponsor.js', 'public/js/admin')
    .js('resources/js/admin/home.js', 'public/js/admin')
    .js('resources/js/guest/search.js', 'public/js/guest')
    .js('resources/js/guest/show.js', 'public/js/guest')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin/app.scss', 'public/css/admin')
    .sass('resources/sass/guest/app.scss', 'public/css/guest')
    .sass('resources/sass/egg.scss', 'public/css');
