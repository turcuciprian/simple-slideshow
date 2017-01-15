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

  // /* Slides */
  // $labels = array(
  //   'name'               => __('Slides', 'simple-slideshow-wpcluj'),
  //   'singular_name'      => __('Slide', 'simple-slideshow-wpcluj'),
  //   'add_new_item'       => __('Add New Slide', 'simple-slideshow-wpcluj'),
  //   'edit_item'          => __('Edit Slide', 'simple-slideshow-wpcluj'),
  //   'new_item'           => __('New Slide', 'simple-slideshow-wpcluj'),
  //   'all_items'          => __('All Slides', 'simple-slideshow-wpcluj'),
  //   'view_item'          => __('View Slide', 'simple-slideshow-wpcluj'),
  //   'search_items'       => __('Search Slides', 'simple-slideshow-wpcluj'),
  //   'not_found'          => __('No Slides found', 'simple-slideshow-wpcluj'),
  //   'not_found_in_trash' => __('No Slides found in Trash', 'simple-slideshow-wpcluj'),
  //   'menu_name'          => __('Slides', 'simple-slideshow-wpcluj')
  // );
  // $args = array(
  //   'labels'             => $labels,
  //   'public'             => true,
  //   'publicly_queryable' => true,
  //   'show_ui'            => true,
  //   'show_in_menu'       => true,
  //   'query_var'          => true,
  //   'rewrite'            =>  array( 'slug' => __('slides', 'simple-slideshow-wpcluj'), 'with_front'=> false ),
  //   'capability_type'    => 'post',
  //   'has_archive'        => false,
  //   'hierarchical'       => false,
  //   'menu_position'      => null,
  //   'supports'           => array( 'title', 'thumbnail', 'editor', 'excerpt'),
  // );
  //

  $args['label'] = 'Slides';
  $args['public'] = true;
  $args['show_ui'] = true;
  $args['supports'] = array('thumbnail','title');
  register_post_type('slides', $args);

  register_post_type( 'slides', $args );
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
      $img_tag = wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'large');
    }
    $result .="<div>".$img_tag."</div>";
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

 add_action('wp_enqueue_scripts', 'ssEnqueueAll');
//
 //Admin scripts and styles callback
 //
 function ssEnqueueAll()
 {
   $path2plug = plugin_dir_url(__FILE__);

   //styles
   wp_register_style('slickCSS', $path2plug."slick/slick.css");
   wp_enqueue_style('slickCSS');
   wp_register_style('slickThemeCSS', $path2plug."slick/slick-theme.css");
   wp_enqueue_style('slickThemeCSS');


  //  scripts

  wp_enqueue_script('jquery');
  $dependencies = array();
  wp_register_script('slickJS', $path2plug.'slick/slick.min.js', $dependencies); //  null,  true
  wp_enqueue_script('slickJS');
  wp_register_script('ssScript', $path2plug.'script.js', $dependencies); // null,  true
  wp_enqueue_script('ssScript');
 }
