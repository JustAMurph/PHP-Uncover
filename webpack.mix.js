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

mix.js('resources/js/app.js', 'public/js/vue.js')
    .js(['node_modules/chart.js/dist/helpers.esm.js', 'node_modules/chart.js/dist/chart.js', 'resources/js/chart.js'], 'public/js/chart.js')
    .js('resources/js/custom.js', 'public/js/custom.js')
    .js("node_modules/bootstrap/dist/js/bootstrap.bundle.js", "public/js/bootstrap.js")
    .vue()
    .sass('resources/sass/custom.scss', 'public/css')
    .sass('resources/css/report.scss', 'public/css')
    .copy('node_modules/bootstrap-icons/icons/', 'public/icons')
