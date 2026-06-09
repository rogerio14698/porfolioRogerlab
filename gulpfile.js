const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));

function compileSass() {
  return src('./sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(dest('./public/css'));
}

function watchSass() {
  watch('./sass/**/*.scss', compileSass);
}

exports.compile = compileSass;
exports.default = series(compileSass, watchSass);

// npx gulp compile
// npx gulp