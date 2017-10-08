/**
 * Use only for development purpose
 * @author Glauber Portella <glauberportella@gmail.com>
 */
var gulp = require('gulp');
var del = require('del');
var composer = require("gulp-composer");

var config = {
    dist: './dist/skyhub-php',
    src: [
        'src/**/*',
        'tests/**/*',
        '.travis.yml',
        'composer.json',
        'composer.lock',
        'README.md',
        'contributors.txt',
        'phpunit.xml'
    ]
};

gulp.task('copy', function() {
    return gulp.src(config.src, {base: '.'})
        .pipe(gulp.dest(config.dist));
});

gulp.task('vendors', function() {
    return composer({
        'working-dir': config.dist,
        'no-dev': true
    });
});

gulp.task('clean', function() {
    return del.sync('./dist');
});

gulp.task('default', ['clean', 'copy', 'vendors']);