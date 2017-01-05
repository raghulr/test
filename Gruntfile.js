module.exports = function (grunt) {

    grunt.initConfig({

        // live browser injection
        browserSync: {
            bsFiles: {
                src : 'app/views/themed/tablesavvy/webroot/css/site.css'
            },
            options: {
                watchTask: true
            }
        },

        // watch changes to less files
        watch: {
            styles: {
                files: ["app/views/themed/tablesavvy/webroot/less/**/*"],
                tasks: ["less"]
            },
            options: {
                spawn: false,
            },
        },

        // compile set less files
        less: {
            development: {
                options: {
                    paths: ["less"],
                    sourceMap: true,
                    sourceMapFilename: 'app/views/themed/tablesavvy/webroot/css/site.css.map',
                    sourceMapURL: 'app/views/themed/tablesavvy/webroot/css/site.css.map',
                    compress: true
                },
                files: {
                    "app/views/themed/tablesavvy/webroot/css/site.css": ["app/views/themed/tablesavvy/webroot/less/*.less", "!app/views/themed/tablesavvy/webroot/less/_*.less"]
                }
            }
        }

    });

    // Load tasks so we can use them
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks('grunt-browser-sync');

    // the default task will show the usage
    grunt.registerTask("default", "Prints usage", function () {
        grunt.log.writeln("");
        grunt.log.writeln("Building Base");
        grunt.log.writeln("------------------------");
        grunt.log.writeln("");
        grunt.log.writeln("* run 'grunt --help' to get an overview of all commands.");
        grunt.log.writeln("* run 'grunt dev' to start watching and compiling LESS changes for development.");
    });

    grunt.registerTask("dev", ["less", "browserSync", "watch"]);

};
