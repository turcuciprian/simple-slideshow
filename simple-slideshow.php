<?php
/*
  Plugin Name: Simple Slideshow WPCluj
  Plugin URI: http://wordpress.org
  Description: A simple plugin for the cluj wordpress metup
  Version: 1.0
  Author: turcuciprian
  Author URI: http://wordpress.org
  License: GPLv2 or later
  Text Domain: simple-slideshow-wpcluj
 */

 // Register a new post type
 add_action('init', 'ssRegisterSlides');
 function ssRegisterSlides()
 {
     $args['label'] = 'Slides';
     $args['public'] = true;
     $args['show_ui'] = true;
     register_post_type('slides', $args);
 }
 
 //Slideshow Shortcode
 function ss_shortcode( $atts ){
 	return "Slideshow  code Goes here";
 }
 add_shortcode( 'ss-shortcode', 'ss_shortcode' );
