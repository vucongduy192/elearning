const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '*': path.resolve('resources/admin/js'),
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

mix.js('resources/front-end/js/app.js', 'public/front-end/js').js(
    'resources/admin/js/app.js',
    'public/admin/js'
);

mix.sass('resources/front-end/sass/app.scss', 'public/front-end/css')
    .sass('resources/admin/sass/app.scss', 'public/admin/css')
    .copyDirectory('resources/admin/dist/img', 'public/dist/img');
