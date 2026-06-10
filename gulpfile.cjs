const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer').default;
const cssnano = require('gulp-cssnano');

function compileSass() {
  // CAMBIADO: Ahora busca dentro de resources/sass/
  return src(['./resources/sass/**/*.scss', './resources/sass/**/*.sass']) 
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(cssnano())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('./public/css')); // Esto sigue dejando el CSS final listo en public
}

function watchSass() {
  // CAMBIADO: El vigilante también mira dentro de resources/sass/
  watch(['./resources/sass/**/*.scss', './resources/sass/**/*.sass'], compileSass);
}

exports.compile = compileSass;
exports.default = series(compileSass, watchSass);

// npx gulp compile
// npx gulp
// comando para ejecutar el watch: npx gulp