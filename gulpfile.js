/**
 * Created by s156386 on 17-7-2017.
 */
var gulp = require('gulp');
var less = require('gulp-less');
var minifyCSS = require('gulp-csso');
var minify = require('gulp-minify');

gulp.task('minify', function () {
   return gulp.src('www/js/*.js')
       .pipe(minify({
           ext: {
               min: '.min.js'
           },
           ignoreFiles: ['*.min.js']
       }))
       .pipe(gulp.dest('public/js'))
});

gulp.task('bootstrap', function(){
    return gulp.src('www/less/bootstrap/bootstrap.less')
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/css'))
});

gulp.task('adminlte', function(){
    return gulp.src('www/less/adminLTE/AdminLTE.less')
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/css'))
});

gulp.task('adminlte_skin', function(){
    return gulp.src('www/less/adminLTE/skins/GEWIS-skin.less')
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/css'))
});

gulp.task('sudosos', function(){
    return gulp.src('www/less/sudosos.less')
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/css'))
});

gulp.task('sudosos_login', function(){
    return gulp.src('www/less/sudosos_login.less')
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/css'))
});

gulp.task('default', [ 'bootstrap', 'adminlte', 'adminlte_skin', 'sudosos', 'sudosos_login', 'minify' ]);
