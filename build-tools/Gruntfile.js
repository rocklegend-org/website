module.exports = function(grunt) {
	require('load-grunt-config')(grunt);
	grunt.initConfig({
	  hub: {
	    all: {
	      src: ['../public/games/note-highway/develop/player/Gruntfile.js',
	      		'../public/games/note-highway/develop/editor/Gruntfile.js',
	      		'../public/assets/Gruntfile.js'],
	      tasks: ['watch'],
	    },
	  },
	});
}