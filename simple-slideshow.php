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
     $args['supports'] = array('thumbnail','title');
     register_post_type('slides', $args);
 }

 //Slideshow Shortcode
 function ss_shortcode( $atts ){
   $result = "
  <div class=\"SimpleSlider\">
  ";
  $args = array(
    'post_type' => 'slides',
    'posts_per_page' => -1
  );
  $query = new WP_Query( $args);

if ( $query->have_posts() ) {
  while ( $query->have_posts() ) {
		$query->the_post();
    if(has_post_thumbnail()){
      $thumbUrl = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
      $slideTitle = get_the_title();
    }
    $result .="<div><img src=\"$thumbUrl\" alt=\"$slideTitle\"/></div>";
  }
}
  $result .="
  </div>
  ";
  return $result;
 }
 add_shortcode( 'ss-shortcode', 'ss_shortcode' );

 //
 //
 //add scripts and styles
 //
 //

 add_action('wp_enqueue_scripts', 'gaboEnqueueAll');
//
 //Admin scripts and styles callback
 //
 function gaboEnqueueAll()
 {
   $path2plug = plugin_dir_url(__FILE__);

   //styles
   wp_register_style('slickCSS', $path2plug."slick/slick.css");
   wp_enqueue_style('slickCSS');


  //  scripts
  wp_enqueue_script('jquery');
  $dependencies = array();
  wp_register_script('slickJS', $path2plug.'slick/slick.min.js', $dependencies);
  wp_enqueue_script('slickJS');
  wp_register_script('ssScript', $path2plug.'script.js', $dependencies);
  wp_enqueue_script('ssScript');
 }
