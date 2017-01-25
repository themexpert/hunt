const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass(
        [
            'app.scss',
            'materialize.min.css',
            'styles.css',
            '../../../node_modules/pace-progress/themes/white/pace-theme-flash.css'
        ], 'public/css/app.css')
        .webpack(
            [
                'script.js',
                'app.js'
            ], 'public/js/app.js')
        .copy('node_modules/materialize-css/fonts', 'public/fonts/');
});
