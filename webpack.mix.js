const mix = require('laravel-mix');

mix.webpackConfig({
    module: {
        rules: [
            {parser: {amd: false}}
        ]
    }
});

mix.js('resources/assets/js/app.js', 'public/js/app.js')
    .sass('resources/assets/sass/app.scss', 'public/css/app.css')
    // .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts', true)
    // .copy('resources/assets/img', 'public/img', true)
    .version()
    .options({
        processCssUrls: false
    });
