const elixir = require('laravel-elixir');
elixir.ready(function () {
    elixir.webpack.mergeConfig({
        module: {
            loaders: [{
                test: /\.json$/,
                loader: 'json'
            }]
        }
    });
});
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
    mix.less('../../../node_modules/nouislider/src/nouislider.less', 'resources/assets/sass/nouislider.css');
    mix.sass(
        [
            'app.scss',
            'materialize.min.css',
            '../../../node_modules/select2/src/scss/core.scss',
            'styles.css',
            'nouislider.css'
        ], 'public/css/app.css')
        .webpack(
            [
                'script.js',
                'app.js'
            ], 'public/js/app.js')
        .copy('node_modules/materialize-css/fonts', 'public/fonts/');
});
