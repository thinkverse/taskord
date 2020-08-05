const mix = require('laravel-mix');
require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/darkmode.scss', 'public/css');

if(mix.inProduction()) {
    mix.purgeCss()
        .version();
}
