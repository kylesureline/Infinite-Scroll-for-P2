<?php

/**
 * Plugin Name: P2 Infinite Scroll
 * Plugin URI: 
 * Description: Adds support to the P2 theme for Jetpack Infinite Scroll
 * Author: Kyle Scheuerlein
 * Version: 1.0
 * License: GPL2
 * Last Updated: June 26, 2016
 */

function infinite_scroll_get_posts() {
	while ( have_posts() ) : the_post();
		p2_load_entry();
	endwhile;
}

function p2_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'type' => 'click',
		'container' => 'postlist',
		'wrapper' => false,
		'render' => infinite_scroll_get_posts,
		'posts_per_page' => 5,
		'footer' => 'page',
	) );
}

add_action( 'after_setup_theme', 'p2_infinite_scroll_init' );

// add CSS file to hide the built-in "old posts link"
wp_register_style( 'p2-infinite-scroll-css', plugin_dir_url( __FILE__ ) . 'p2-infinite-scroll.css' );
wp_enqueue_style('p2-infinite-scroll-css');
