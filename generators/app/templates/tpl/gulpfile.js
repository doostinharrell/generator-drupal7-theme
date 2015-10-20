// Require Node Modules
var gulp          = require('gulp'),
    browsersync   = require('browser-sync'),
    filter        = require('gulp-filter'),
    uglify        = require('gulp-uglify'),
    concat        = require('gulp-concat'),
    flatten       = require('gulp-flatten'),
    ext           = require('gulp-ext-replace'),
    sass          = require('gulp-sass'),
    globbing      = require('gulp-css-globbing'),
    autoprefixer  = require('gulp-autoprefixer'),
    minifycss     = require('gulp-minify-css'),
    sourcemaps    = require('gulp-sourcemaps'),
    foundation    = 'bower_components/foundation/',
    reload        = browsersync.reload;

// JS Task
gulp.task('js', function() {
  gulp.src(foundation + 'js/foundation.min.js')
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(sourcemaps.write('../maps/js'))
    .pipe(gulp.dest('build/js'));

  gulp.src(foundation + 'js/foundation/*.js')
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(sourcemaps.write('../maps/js'))
    .pipe(gulp.dest('build/js/foundation'));

  gulp.src(foundation + 'js/vendor/*.js')
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(sourcemaps.write('../maps/js'))
    .pipe(gulp.dest('build/js/vendor'));

  gulp.src('dev/js/behavior/*.js')
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(sourcemaps.write('../maps/js'))
    .pipe(gulp.dest('build/js/behavior'));

  gulp.src('dev/js/functions.js')
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(concat({ path: 'functions.js', stat: {mode: 0666} }))
    .pipe(sourcemaps.write('../maps/js'))
    .pipe(gulp.dest('build/js'))
});

// Sass Task
gulp.task('sass', function() {
  gulp.src('dev/sass/styles.scss')
    .pipe(sourcemaps.init())
    .pipe(globbing({ extensions: ['.scss'] }))
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(minifycss())
    .pipe(sourcemaps.write('../maps/css'))
    .pipe(gulp.dest('build/css'))

    // Reload browser
    .pipe(reload({stream: true}))
});

// Browser Sync
gulp.task('browser-sync', function() {
  browsersync({
    proxy: "<%= proxyAddress %>",
    port: 3000,
    ui: {
      port: 3001,
      weinre: {
        port: 3002
      }
    }
  })
});

// Watch for changes
gulp.task('watch', function(){
  gulp.watch('dev/**/*', ['js', 'sass'])
});

// Build project.
gulp.task('build', ['js', 'sass']);

// Run run browser-sync and watch for changes
gulp.task('default', ['browser-sync', 'watch']);
