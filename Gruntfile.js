'use strict';

module.exports = function( grunt ) {
  // load all tasks
  require( 'load-grunt-tasks' )( grunt, { scope: 'devDependencies' } );

  grunt.config.init( {
    pkg: grunt.file.readJSON( 'package.json' ),

    dirs: {
      css: 'assets/css',
      js: 'assets/js'
    },

    makepot: {
      target: {
        options: {
          domainPath: '/languages/',
          potFilename: '<%= pkg.name %>.pot',
          potHeaders: {
            poedit: true,
            'x-poedit-keywordslist': true
          },
          processPot: function( pot, options ) {
            pot.headers[ 'report-msgid-bugs-to' ] = 'https://www.colorlib.com/';
            pot.headers[ 'language-team' ] = 'Colorlib <office@colorlib.com>';
            pot.headers[ 'last-translator' ] = 'Colorlib <office@colorlib.com>';
            pot.headers[ 'language-team' ] = 'Colorlib <office@colorlib.com>';
            return pot;
          },
          updateTimestamp: true,
          type: 'wp-theme'

        }
      }
    },

    addtextdomain: {
      target: {
        options: {
          updateDomains: true,
          textdomain: '<%= pkg.name %>'
        },
        files: {
          src: [
            '*.php',
            '!node_modules/**'
          ]
        }
      }
    },

    checktextdomain: {
      standard: {
        options: {
          text_domain: [ 'tyche', 'epsilon-framework' ], //Specify allowed
                                                         // domain(s)
          create_report_file: 'true',
          keywords: [ //List keyword specifications
            '__:1,2d',
            '_e:1,2d',
            '_x:1,2c,3d',
            'esc_html__:1,2d',
            'esc_html_e:1,2d',
            'esc_html_x:1,2c,3d',
            'esc_attr__:1,2d',
            'esc_attr_e:1,2d',
            'esc_attr_x:1,2c,3d',
            '_ex:1,2c,3d',
            '_n:1,2,4d',
            '_nx:1,2,4c,5d',
            '_n_noop:1,2,3d',
            '_nx_noop:1,2,3c,4d'
          ]
        },
        files: [
          {
            src: [
              '**/*.php',
              '!**/node_modules/**',
            ], //all php
            expand: true
          } ]
      }
    },

    clean: {
      init: {
        src: [ 'build/' ]
      },
      build: {
        src: [
          'build/*',
          '!build/<%= pkg.name %>.zip'
        ]
      },
    },

    copy: {
      readme: {
        src: 'readme.md',
        dest: 'build/readme.txt'
      },
      build: {
        expand: true,
        src: [
          '**',
          '!.sass-cache/**',
          '!node_modules/**',
          '!build/**',
          '!readme.md',
          '!README.md',
          '!phpcs.ruleset.xml',
          '!Gruntfile.js',
          '!package.json',
          '!set_tags.sh',
          '!tyche.zip',
          '!nbproject/**' ],
        dest: 'build/'
      }
    },

    compress: {
      build: {
        options: {
          pretty: true,
          archive: '<%= pkg.name %>.zip'
        },
        expand: true,
        cwd: 'build/',
        src: [ '**/*' ],
        dest: '<%= pkg.name %>/'
      }
    },

    imagemin: {
      jpg: {
        options: {
          progressive: true
        }
      },
      png: {
        options: {
          optimizationLevel: 7
        }
      },
      dynamic: {
        files: [
          {
            expand: true,
            cwd: 'assets/images/',
            src: [ '**/*.{png,jpg,gif}' ],
            dest: 'assets/images/'
          } ]
      }
    },

    sass: {
      dist: {
        options: {
          style: 'expanded',
          sourcemap: 'none',
        },
        files: [
          {
            expand: true,
            cwd: 'assets/sass/',
            src: [ '*.scss' ],
            dest: 'assets/css/',
            ext: '.css'
          } ]
      }
    }

  } );
  grunt.config( 'watch', {
    scss: {
      tasks: [ 'sass:dist' ],
      files: [
        'assets/sass/*.scss',
        'assets/sass/**/*.scss',
        'assets/sass/**/**/*.scss'
      ]
    }
  } );

  grunt.event.on( 'watch', function( action, filepath ) {
    // Determine task based on filepath
    var get_ext = function( path ) {
      var ret = '';
      var i = path.lastIndexOf( '.' );
      if ( -1 !== i && i <= path.length ) {
        ret = path.substr( i + 1 );
      }
      return ret;
    };
    switch ( get_ext( filepath ) ) {
        // PHP
      case 'php' :
        grunt.config( 'paths.php.files', [ filepath ] );
        break;
        // JavaScript
      case 'js' :
        grunt.config( 'paths.js.files', [ filepath ] );
        break;
      case 'scss':
        grunt.config( 'paths.scss.files', [ filepath ] );
        break;
    }
  } );

  // Check Missing Text Domain Strings
  grunt.registerTask( 'textdomain', [
    'checktextdomain'
  ] );

  // Minify Images
  grunt.registerTask( 'minimg', [
    'imagemin:dynamic'
  ] );

  grunt.registerTask( 'startSass', [
    'sass'
  ] );

  // Build task
  grunt.registerTask( 'build-archive', [
    'clean:init',
    'copy',
    'compress:build',
    'clean:init'
  ] );
};
