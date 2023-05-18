const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/arquivoVirtualHome.scss', 'public/css')
    .js('resources/js/insertDocument.js', 'public/js')
    .sass('resources/sass/documentDetail.scss', 'public/css')
    .sass('resources/sass/home.scss', 'public/css')
    .sass('resources/sass/navbar.scss', 'public/css')
    .sass('resources/sass/table.scss', 'public/css')
    .sass('resources/sass/variables.scss', 'public/css')
    .sass('resources/sass/history.scss', 'public/css')
    .sass('resources/sass/auth.scss', 'public/css');
mix.browserSync('127.0.0.1:8000');
