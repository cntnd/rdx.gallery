const gulp = require('gulp');
const del = require('del');
const log = require('fancy-log');
const yaml = require('read-yaml-file')

gulp.task('clean', function () {
    return del(['module/**/*']);
});

gulp.task('module', function () {
    return yaml('module.yml').then(data => {
        log("Module data: ", data);
        return gulp.src(['src/**'])
            .pipe(gulp.dest('module/' + data.Name + ' [' + data.ModuleId + ']'));
    })
});

gulp.task('default', gulp.series('clean','module'));
