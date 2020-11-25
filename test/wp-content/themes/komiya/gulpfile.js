var gulp = require("gulp");


// sass
var sass = require("gulp-sass");
gulp.task("sass", function() {
    gulp.src("sass/**/*.scss")
        .pipe(sass())
        .pipe(gulp.dest("./css"));
});


// prefix
var autoprefixer = require("gulp-autoprefixer");
gulp.task("sass", function() {
    gulp.src("sass/**/*.scss")
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulp.dest("./css"));
});


// watch
gulp.task("default", function() {
    gulp.watch("sass/**/*.scss",["sass"]);
});


// browser-sync
var browser = require("browser-sync");
gulp.task("server", function() {
    browser.init({
        proxy: 'http://komiya.test/',
    });
});
gulp.task("sass", function() {
    gulp.src("sass/**/*.scss")
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulp.dest("./css"))
        .pipe(browser.reload({stream:true}))
});
gulp.task("default",['server'], function() {
    gulp.watch("sass/**/*.scss",["sass"]);
});


// plumber
var plumber = require("gulp-plumber");
gulp.task("sass", function() {
    gulp.src("sass/**/*.scss")
        .pipe(plumber())
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulp.dest("./css"))
        .pipe(browser.reload({stream:true}))
});
