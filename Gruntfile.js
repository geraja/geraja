module.exports = function(grunt) {
  require('load-grunt-tasks')(grunt);

  var mozjpeg = require('imagemin-mozjpeg');

  grunt.initConfig({
    clean: ['public'],

    copy: {
      fonts: {
        files: [
          {expand: true, cwd: 'assets/fonts/', src: ['**'], dest: 'public/fonts/'}
        ]
      },

      sounds: {
        files: [
          {expand: true, cwd: 'assets/sounds/', src: ['**'], dest: 'public/sounds/'}
        ]
      }
    },

    sass: {
      dist: {
        options: {
          style: 'compressed',
          loadPath: 'bower_components'
        },
        files: {
          'public/css/main.css': 'assets/sass/main.scss'
        }
      },

      dev: {
        options: {
          style: 'expanded'
        },
        files: {
          'public/css/main.css': 'assets/sass/main.scss'
        }
      }
    },

    watch: {
      sass: {
        files: 'assets/sass/*.scss',
        tasks: ['sass:dev']
      },
      php: {
          files: ['app/**/*.php']
      },
      js: {
        files: ['assets/js/*.js'],
        tasks: ['concat']
      },
    },

    concat: {
      options: {
        separator: ';',
        compress: true,
      },
      dist: {
        src: [
        'bower_components/jquery/dist/jquery.min.js',
        'assets/js/main.js',
        ],
        dest: 'public/js/main.js'
      }
    },

    uglify: {
      options: {
        mangle: false
      },

      frontend: {
        files: {
          'public/js/main.js': 'public/js/main.js'
        }
      }
    },

    imagemin: {
      dynamic: {
        options: {
          optimizationLevel: 3,
          svgoPlugins: [{ removeViewBox: false }],
          use: [mozjpeg()]
        },
        files: [{
          expand: true,
          cwd: './assets/images/',
          src: ['**/*.{png,jpg,gif,svg}'],
          dest: './public/images/'
        }]
      }
    },

    browserSync: {
      dev: {
        bsFiles: {
          src: ['app/**/*.php', 'public/css/*.css', 'public/js/*.js']
        },
        options: {
          watchTask: true,
          proxy: 'http://localhost/geraja/'
        }
      }
    },

  });

  grunt.registerTask('clean_public', ['clean']);
  grunt.registerTask('build', ['sass:dist', 'concat', 'uglify', 'imagemin', 'copy']);
  grunt.registerTask('default', ['build', 'browserSync', 'watch']);
};
