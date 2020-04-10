const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '*': path.resolve('resources/back-end/js'),
            public: path.resolve('public'),
        },
    },
});

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

mix.js('resources/front-end/js/app.js', 'public/front-end/js')
    .js('resources/back-end/js/app.js', 'public/back-end/js')
    .styles(
        [
            'node_modules/bootstrap/dist/css/bootstrap.min.css',
            'node_modules/admin-lte/dist/css/AdminLTE.css',
            'node_modules/admin-lte/dist/css/skins/_all-skins.min.css',
        ],
        'public/back-end/css/lib.css'
    )
    .scripts(['node_modules/admin-lte/dist/js/demo.js'], 'public/back-end/js/lib.js');

mix.sass('resources/front-end/sass/app.scss', 'public/front-end/css')
    .sass('resources/back-end/sass/app.scss', 'public/back-end/css')
    .copyDirectory('resources/back-end/dist/img', 'public/dist/img');
