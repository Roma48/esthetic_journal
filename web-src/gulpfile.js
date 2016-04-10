var gulp = require('gulp');
var less = require('gulp-less');
var path = require('path');
var plumber = require('gulp-plumber');
var watchLess = require('gulp-watch-less');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');

gulp.task('less', function () {
    return gulp.src(['less/*.less'])
        .pipe(less({
            paths: [ path.join('less') ]
        }))
        .pipe(gulp.dest('../web/css/'));
});

gulp.task('js', function(){
    return gulp.src([
        'bower_components/jquery/dist/jquery.min.js',
        'js/*.js'
    ])
        .pipe(concat('main.js'))
        .pipe(gulp.dest('../web/js/'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest('../web/js/'));
});


gulp.task('watch', function () {
    gulp.watch(['less/*.less'], ['less']);
    gulp.watch(['js/*.js'], ['js']);
});

gulp.task('default', ['less', 'js']);