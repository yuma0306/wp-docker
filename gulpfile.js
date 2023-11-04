// gulpの読み込み
const gulp = require('gulp');
// Sass読み込み
const sass = require('gulp-dart-sass');
// ソースマップ
const sourcemaps = require('gulp-sourcemaps');
// browser-syncの読み込み
const browserSync = require('browser-sync');
// エラー時に終了させないための機能
const plumber = require('gulp-plumber');
// エラー発生時のアラート出力
const notify = require('gulp-notify');
// 圧縮
const uglify = require('gulp-uglify');
// ファイルのリネーム
const rename = require('gulp-rename');
// webp
const webp = require('gulp-webp');
// 削除np
const del = require('del');
// localhost
const localhost = 'www.mysite.local';

// gulp実行前パス
const srcBase = './src/'
const srcPath = {
    scss: `${srcBase}scss/**/*.scss`,
    js: `${srcBase}js/**/*.js`,
    img: `${srcBase}img/**/*.{jpg,jpeg,png}`,
};

// gulp実行後パス
const destBase = `./html/wp-content/themes/wp-template/assets/`;
const destPath = {
    css: `${destBase}css/`,
    js: `${destBase}js/`,
    img: `${destBase}img/`,
};

// .scssのコンパイルタスク
const compSass = () => {
    return gulp
        .src(srcPath.scss, {
            sourcemaps: true,
        })
        // コンパイル時のスタイル設定
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(sourcemaps.write('/maps'))
        .pipe(
            plumber({
            // plumberのエラー表示(notify)
                errorHandler: notify.onError('Error!!:<%= error.message %>'),
            })
        )
        // 保存先のファイルの指定
        .pipe(gulp.dest(destPath.css))
        // .pipe(browserSync.stream());
};

// jsファイルの圧縮
const minifyJs = () => {
    return gulp
        .src(srcPath.js)
		.pipe(uglify())
		.pipe(gulp.dest(destPath.js));
}

// ブラウザ自動リロード
const browserSyncFunc = () => {
    browserSync.init(browserSyncOption);
};

// ブラウザ自動リロードオプション
const browserSyncOption = {
    proxy: localhost, // ローカルホスト名を設定
    open: false,
    watchOptions: {
        debounceDelay: 1000,
    },
    reloadOnRestart: true,
};

// リロードの実行
const browserSyncReload = (done) => {
    browserSync.reload();
    done();
};

// webp画像への変換
const changeWebp = () => {
    return gulp.src(srcPath.img)
        .pipe(webp())
        .pipe(webp({
            quality: 90,
            method: 4,
        }))
        .pipe(gulp.dest(destPath.img))
}

// ファイル監視
const watchFiles = () => {
    gulp.watch(srcPath.img, gulp.series(changeWebp, browserSyncReload));
    gulp.watch(srcPath.js, gulp.series(minifyJs, browserSyncReload));
    gulp.watch(srcPath.scss, gulp.series(compSass, browserSyncReload));
};

// 開発時
exports.default = gulp.series(
    gulp.parallel(compSass,minifyJs,changeWebp),
    gulp.parallel(watchFiles, browserSyncFunc),
);
