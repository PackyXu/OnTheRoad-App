/*var gulp = require('gulp');gulp.task('default', function() {    // 将你的默认的任务代码放在这});*/const elixir = require('laravel-elixir');require('laravel-elixir-vue-2');elixir((mix) => {    mix.sass('app.scss')    .webpack('app.js');    mix.version(['js/app.js','css/app.css']);});