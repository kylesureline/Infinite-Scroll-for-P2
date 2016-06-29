<?php

/**
 * Plugin Name: Infinite Scroll for P2
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
function infinite_scroll_p2_check_theme() {
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
add_action( 'admin_init', 'infinite_scroll_p2_check_theme' );

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

// use JavaScript to hide the default "Older posts" link
// this way visitors that don't have JavaScript enabled can still see older posts
function infinite_scroll_p2_link_scripts() {
 
	wp_enqueue_script( 'infinite-scroll-p2', plugin_dir_url( __FILE__ ) . 'infinite-scroll-p2.js' );

}
add_action( 'wp_enqueue_scripts', 'infinite_scroll_p2_link_scripts' );
