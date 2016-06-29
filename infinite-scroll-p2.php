<?php

/**
 * Plugin Name: P2 Infinite Scroll
 * Plugin URI: 
 * Description: Adds support to the P2 theme for Jetpack Infinite Scroll
 * Author: Kyle Scheuerlein
 * Version: 1.0
 * License: GPL2
 * Last Updated: June 29, 2016
 */

/**
 * Don't activate if P2 isn't active
 */
function checkTheme() {
	$plugin = plugin_basename( __FILE__ );
	$plugin_data = plugin_basename( __FILE__, false );
	$theme = wp_get_theme();
	if( 'P2' == $theme->name || 'P2' == $theme->parent_theme ) {
		// do nothing
	}
	else {
		deactivate_plugins( $plugin );
		wp_die( "<strong>Infinite Scroll for P2</strong> requires the <strong>P2 Theme</strong> or a child theme of it, and has been deactivated!<br /><br />Back to the WordPress <a href='".get_admin_url(null, 'plugins.php')."'>Plugins page</a>." );
	}
}
add_action( 'admin_init', 'checkTheme' );

function infinite_scroll_get_posts() {
	while ( have_posts() ) : the_post();
		p2_load_entry();
	endwhile;
}

function infinite_scroll_p2_init() {
	add_theme_support( 'infinite-scroll', array(
		'type' => 'click',
		'container' => 'postlist',
		'wrapper' => false,
		'render' => infinite_scroll_get_posts,
		'posts_per_page' => 5,
		'footer' => 'page',
	) );
}

add_action( 'after_setup_theme', 'infinite_scroll_p2_init' );

// add CSS file to hide the built-in "old posts link"
wp_register_style( 'infinite-scroll-p2-css', plugin_dir_url( __FILE__ ) . 'infinite-scroll-p2.css' );
wp_enqueue_style('infinite-scroll-p2-css');
