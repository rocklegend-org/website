module.exports = function(grunt) {
	require('load-grunt-config')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		js_src: 'js',
		js_min: 'js-min',
		compass: {
			dev: {
				options: {
					cssDir: 'css',
					sassDir: 'css_sass',
					environment: 'development'
				}
			}
		},
		concat: {
			options: {
				separator: ';',
				stripBanners: true
			},
			rl: {
				src: [
						'<%= js_src %>/rl/main.js', 
						'<%= js_src %>/rl/*.js'],
				dest: '<%= js_min %>/rl.cat.js'
			},
			plugins: {
				src: ['<%= js_src %>/plugins/jquery.min.js', 
					  '<%= js_src %>/plugins/modernizr.2.8.2.custom.js',
					  '<%= js_src %>/plugins/jquery-ui-1.10.4.min.js', 
					  '<%= js_src %>/plugins/jquery.transit.js', 
					  '<%= js_src %>/plugins/jquery.form.js', 
					  '<%= js_src %>/plugins/jquery.autoSuggest.js', 
					  '<%= js_src %>/plugins/tipped.js', 
					  '<%= js_src %>/plugins/jquery.ui.touch.punch.min.js', 
					  '<%= js_src %>/plugins/fastclick.js',  
					  '<%= js_src %>/plugins/jquery.nscroll.min.js', 
					  '<%= js_src %>/plugins/foundation.min.js', 
					  '<%= js_src %>/plugins/jquery.backstretch.min.js',
					  '<%= js_src %>/plugins/fancybox/jquery.fancybox.pack.js',
					  '<%= js_src %>/plugins/jquery.tinysort.min.js'],
				dest: '<%= js_min %>/plugins.cat.js'
			},
		},
		uglify: {
			rl: {
				src: ['<%= concat.rl.dest %>'],
				dest: '<%= js_min %>/rl.min.js'
			},
			plugins: {
				src: ['<%= concat.plugins.dest %>'],
				dest: '<%= js_min %>/plugins.min.js'
			}
		},
		watch: {
			main: {
				files: ['<%= js_src %>/rl/**/*.js'],
				tasks: ['concat:rl', 'uglify:rl']
			},

			plugins: {
				files: ['<% js_src %>/plugins/**/*.js'],
				tasks: ['concat:plugins', 'uglify:plugins']
			},

			css: {
				files: ['css_sass/**/*.scss'],
				tasks: ['compass:dev']
			}
		}
	});

	grunt.registerTask('default', ['concat', 'uglify']);

};

