const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const cssnano = require('gulp-cssnano');

function compileSass() {
  return src(['./sass/**/*.scss', './sass/**/*.sass']) // Soporta ambas extensiones
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(cssnano())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('./public/css'));
}

function watchSass() {
  watch(['./sass/**/*.scss', './sass/**/*.sass'], compileSass);
}

exports.compile = compileSass;
exports.default = series(compileSass, watchSass);

// npx gulp compile
// npx gulp