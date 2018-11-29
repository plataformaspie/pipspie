let mix = require('laravel-mix');

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

 mix.styles([
     'resources/assets/planificacion/bootstrap/dist/css/bootstrap.min.css',
     'resources/assets/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css',
     'resources/assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.css',
     'resources/assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css',
     'resources/assets/plugins/bower_components/custom-select/custom-select.css',
     'resources/assets/planificacion/css/animate.css',
     'resources/assets/planificacion/css/style.css',
     'resources/assets/planificacion/css/colors/megna.css',
     'resources/assets/planificacion/css/colors/blue.css'
 ], 'public/css/tpl_planificacion.css')
 .scripts([
     'resources/assets/plugins/bower_components/jquery/dist/jquery.min.js',
     'resources/assets/planificacion/bootstrap/dist/js/tether.min.js',
     'resources/assets/planificacion/bootstrap/dist/js/bootstrap.min.js',
     'resources/assets/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js',
     'resources/assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js',
     'resources/assets/planificacion/js/jquery.slimscroll.js',
     'resources/assets/planificacion/js/waves.js',
     'resources/assets/planificacion/js/custom.min.js',
     'resources/assets/planificacion/js/cbpFWTabs.js',
     'resources/assets/planificacion/js/validator.js',
     'resources/assets/planificacion/js/mask.js',
     'resources/assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js'
 ], 'public/js/tpl_planificacion.js')
 .js(['resources/assets/js/app.js'], 'public/js/app-planificacion.js');
