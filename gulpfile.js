var elixir = require('laravel-elixir');

var paths = {
    js : 'public/assets/js/',
    jsLibs : 'public/assets/js/libs/',
    css : 'public/assets/css/'
};
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

elixir(function(mix) {
    mix.sass(['blog/main.scss', 'simditor/style-config.scss'], paths.css + 'styles.css');

    mix.sass(['simditor/simditor.scss', 'pikaday/pikaday.scss'], paths.css + 'simditor.css');

    mix.sass('cms/cms.scss', paths.css + 'cms.css');


    mix.copy('resources/assets/js/jquery/jquery3_1_0.js', paths.jsLibs + 'jquery.js');

    mix.scripts([
        'simditor/module.js',
        'simditor/hotkeys.js',
        'simditor/uploader.js',
        'simditor/simditor.js',
        'simditor/beautify-html.js',
        'simditor/simditor-html.js',
        'pikaday/moment.js',
        'pikaday/pikaday.js',
        'main.js',
        'editor.js'
        //'simditor/simditor-dropzone.js'

    ], paths.jsLibs + 'simditor.js');
});
