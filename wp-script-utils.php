<?php

/**
 * Plugin Name: WordPres Script Utils
 * Plugin URI: http://theAverageDev.com
 * Description: Script and style utilities for WordPress projects.
 * Version: 1.1
 * Author: theAverageDev
 * Author URI: http://theAverageDev.com
 * License: GPL 2.0
 */

require dirname(__FILE__) . '/vendor/autoload_52.php';

function js_backbone_utilities_load() {
	$script_manager = Scripts::instance( plugins_url( '/js', __FILE__ ) );

	// always register the main one
	$src  = $script_manager->get_src( '/js-hooks.js' );
	$deps = array( 'jquery', 'underscore', 'backbone' );
	wp_register_script( 'js-hooks', $src, $deps, null, true );

	// register the other ones
	$scripts = array(
		'cmb2-checkbox-toggle' => '/cmb2-checkbox-toggle.js'
	);
	foreach ( $scripts as $handle => $script ) {
		$src = $script_manager->get_src( $script );
		wp_register_script( $handle, $src, $deps, null, true );
	}
}

add_action( 'admin_init', 'js_backbone_utilities_load' );
add_action( 'admin_enqueue_scripts', 'js_backbone_main_enqueue', 999 );
add_action( 'wp_enqueue_scripts', 'js_backbone_main_enqueue', 999 );
