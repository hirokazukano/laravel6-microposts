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

mix
  .js(['public/js/js1.js', 'public/js/js2.js'], 'public/js/index.min.js')
  .styles(['public/css/style1.css', 'public/css/style2.css'], 'public/css/index.min.css')
  .browserSync({
    files: [
      './**/*.php',
      './**/**/*.php',
      './**/**/**/*.php',
      './public/css/*.css',
      './public/js/*.js',
      './public/img/*.*',
    ],
    proxy: {
      target: '192.168.33.29/github/techacademy/laravel6/microposts6/public',
    }
  });
