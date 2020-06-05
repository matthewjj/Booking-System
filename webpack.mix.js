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
   .sass('resources/sass/app.scss', 'public/css')
   .scripts([
        'public/js/app.js',
        'node_modules/@fullcalendar/core/main.js',
        'node_modules/@fullcalendar/daygrid/main.js',
        'node_modules/@fullcalendar/timegrid/main.js',
        'node_modules/@fullcalendar/interaction/main.js',
        'node_modules/@fullcalendar/list/main.js'
    ], 'public/js/app.js')
   .combine([
        'public/css/app.css',
        'node_modules/@fullcalendar/core/main.css',
        'node_modules/@fullcalendar/daygrid/main.css',
        'node_modules/@fullcalendar/timegrid/main.css',
        'node_modules/@fullcalendar/list/main.css',
    ], 'public/css/app.css');
