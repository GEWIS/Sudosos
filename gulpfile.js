/**
 * Created by s156386 on 17-7-2017.
 */
var gulp = require('gulp');
var less = require('gulp-less');
var minifyCSS = require('gulp-csso');
var minify = require('gulp-minify');

gulp.task('minify', function () {
   return gulp.src('public/js/*.js')
       .pipe(minify({
           ext: {
               src: '.js',
               min: '.min.js'
           },
           ignoreFiles: ['*.min.js']
       }))
       .pipe(gulp.dest('public/js'))
});

gulp.task('css', function(){
    return gulp.src('public/less/sudosos.less')
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/css'))
});

gulp.task('default', [ 'css', 'minify' ]);