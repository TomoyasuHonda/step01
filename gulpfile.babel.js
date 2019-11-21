import gulp from 'gulp';
import webpackConfig from './webpack.config.js';
import webpack from 'webpack-stream';
import browserSync from 'browser-sync';
import notify from 'gulp-notify';
import plumber from 'gulp-plumber';
import eslint from 'gulp-eslint';
import sass from "gulp-sass";
import sassGlob from "gulp-sass-glob";
//npmでよく出るエラー、警告集
//https://qiita.com/M-ISO/items/d693ac892549fc95c14c

//gulpタスクの作成
gulp.task('build', function(){
  gulp.src('resources/assets/js/app.js')
  .pipe(plumber({
    errorHandler: notify.onError("Error:<%= error.message %>")
  }))
  .pipe(webpack(webpackConfig))
  .pipe(gulp.dest('public/assets/js'));
});

gulp.task('bs-reload', function(){
  browserSync.reload();
});

gulp.task('eslint', function(){
  return gulp.src(['resources/**/*.js'])
    .pipe(plumber({
      errorHandler: function(error) {
        const taskName = 'eslint';
        const title = '[task]' + taskName + '' + error.plugin;
        const errorMsg = 'error: ' + error.message;
        console.error(title + '\n' + errorMsg);
        notify.onError({
          title: title,
          message: errorMsg,
          time: 3000
        });
      }
    }))
    .pipe(eslint({ useEslintrc: true }))
    .pipe(eslint.format())
    .pipe(eslint.failOnError())
    .pipe(plumber.stop());
});

//scssをコンパイル
var paths = {
    "scss": "resources/assets/sass/", //作業するscssのフォルダ
    "css": "public/assets/css/"  //コンパイルして保存するcssのフォルダ
  }
  gulp.task('scss', function() {
    return gulp.src(paths.scss + '**/*.scss')
    .pipe(sassGlob({
        ignorePaths: [
          'foundation/_reset.scss'
        ]
    }))
    .pipe(sass({outputStyle: "expanded"}))
    .pipe(gulp.dest(paths.css + 'style.css'))
  });

//Gulpを使ったファイルの監視
gulp.task('default', ['eslint', 'build', 'scss'], function(){
  gulp.watch('./resources/assets/**/*.js', ['build']);
  gulp.watch('./*.html', ['bs-reload']);
  gulp.watch('./public/**/*.+(js|css)', ['bs-reload']);
  gulp.watch('./resources/assets/**/*.js', ['eslint']);
  gulp.watch('./resources/assets/sass/**/*.scss', ['scss']);
});


