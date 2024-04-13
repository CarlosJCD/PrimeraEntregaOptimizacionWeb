const { src, dest, watch, parallel } = require("gulp");

// CSS
const sass = require("gulp-sass")(require("sass"));

const paths = {
    scss: "src/scss/**/*.scss",
    js: "src/js/**/*.js",
    imagenes: "src/img/**/*",
};
function css() {
    return src(paths.scss)
        .pipe(sass({ outputStyle: "expanded" }))
        .pipe(dest("public/build/css"));
}
function javascript() {
    return src(paths.js).pipe(dest("./public/build/js"));
}

function dev(done) {
    watch(paths.scss, css);
    watch(paths.js, javascript);
    done();
}

exports.css = css;
exports.js = javascript;
exports.dev = parallel(css, javascript, dev);
