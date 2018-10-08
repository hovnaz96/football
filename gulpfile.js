var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

gulp.task('admin', function () {
  return gulp.src('resources/assets/sass/admin/**/*.scss')
    .pipe($.sass({
        outputStyle: 'compressed'
      })
      .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9']
    }))
    .pipe(gulp.dest('public/admin/css'));
});

gulp.task('home', function () {
    return gulp.src('resources/assets/sass/home/**/*.scss')
        .pipe($.sass({
            outputStyle: 'compressed'
        })
            .on('error', $.sass.logError))
        .pipe($.autoprefixer({
            browsers: ['last 2 versions', 'ie >= 9']
        }))
        .pipe(gulp.dest('public/css'));
});

gulp.task('admin-watch', ['admin'], function () {
    gulp.watch(['resources/assets/sass/admin/**/*.scss'], ['admin']);
});

gulp.task('home-watch', ['home'], function () {
    gulp.watch(['resources/assets/sass/home/**/*.scss'], ['home']);
});

gulp.task('default', ['admin','home'], function () {
  gulp.watch(['resources/assets/sass/admin/**/*.scss'], ['admin']);
  gulp.watch(['resources/assets/sass/home/**/*.scss'], ['home']);
});
