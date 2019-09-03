module.exports = function(grunt) {
	require('load-grunt-config')(grunt);
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		js_src_dir: 'src',
		js_lib_dir: 'lib',
		js_build_dir: 'build',
		js_build_name: 'game',
		concat: {
			options: {
				separator: ';'
			},
			main: {
				options: {
					banner: '/*! rocklegend <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n\n'
				},
				src: [
					'<%= js_lib_dir %>/*.js',
					'<%= js_src_dir %>/RL.js',
					'<%= js_src_dir %>/RL.Config.js',
					'<%= js_src_dir %>/managers/RL.InteractionManager.js',
					'<%= js_src_dir %>/managers/*.js',
					'<%= js_src_dir %>/states/*.js',
					'<%= js_src_dir %>/objects/*.js',				
					'<%= js_src_dir %>/*.js'
				],
				dest: '<%= js_build_dir %>/<%= js_build_name %>.cat.js'
			}
		},
		uglify: {
			options: {
				preserveComments: false,
				banner: '/*! rocklegend <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n\n'
			},
			main: {
				src: ['<%= concat.main.dest %>'],
				dest: '<%= js_build_dir %>/<%= js_build_name %>.js'
			}
		},
		watch: {
			main: {
				files: ['<%= js_src_dir %>/**/*.js'],
				tasks: ['concat', 'uglify']
			}
		}
	});

	grunt.registerTask('default', ['concat', 'uglify']);

};

