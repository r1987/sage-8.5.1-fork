<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


/**
 * Open-Graph Tags
*/
function sage_add_opengraph_doctype( $output ) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
  }
add_filter('language_attributes', __NAMESPACE__ . '\\sage_add_opengraph_doctype');


function sage_open_graph_tags() {
  global $post;

  $placeholder_image = get_stylesheet_directory_uri() . '/dist/images/placeholder.png';

  if ( !is_singular()) {

    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '"/>';
    echo '<meta property="og:url" content="' . get_bloginfo('url') . '"/>';
    echo '<meta property="og:title" content="' . get_bloginfo('name') . '"/>';
    echo '<meta property="og:description" content="' . get_bloginfo('description') . '"/>';
    echo '<meta property="og:image:width" content="1200"/>';
    echo '<meta property="og:image:height" content="630"/>';
    echo '<meta property="og:image" content="' . $placeholder_image . '"/>';
    echo '<meta name="twitter:card" content="summary_large_image">';
    echo '<meta name="twitter:title" content="' . get_bloginfo('name') . '">';
    echo '<meta name="twitter:description" content="' . get_bloginfo('description')  . '">';
    echo '<meta name="twitter:image" content="' . $placeholder_image . '">';
    echo '<meta itemprop="name" content="' . get_bloginfo('name') . '"/>';
    echo '<meta itemprop="description" content="' . get_bloginfo('description') . '"/>';
    echo '<meta itemprop="image" content="' . $placeholder_image . '">';
  
  } else {

    $content = $post->post_content;
    $description = $content;
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
    $og_image = ( has_post_thumbnail( $post->ID ) ) ? $featured_image[0] : $placeholder_image;

    // echo '<meta property="fb:admins" content="YOUR USER ID"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:description" content="' . strip_tags(substr($description, 0, 250)) . '"/>';
    echo '<meta property="og:image:width" content="1200"/>';
    echo '<meta property="og:image:height" content="630"/>';
    echo '<meta property="og:image" content="' . $og_image . '"/>';
    echo '<meta name="twitter:card" content="summary_large_image">';
    // echo '<meta name="twitter:site" content="@soome100">';
    // echo '<meta name="twitter:creator" content="@soome100">';
    echo '<meta name="twitter:title" content="' . get_the_title() . '">';
    echo '<meta name="twitter:description" content="' . strip_tags(substr($description, 0, 120)) . '">';
    echo '<meta name="twitter:image" content="' . $og_image . '">';
    echo '<meta itemprop="name" content="' . get_the_title() . '"/>';
    echo '<meta itemprop="description" content="' . strip_tags(substr($description, 0, 250)) . '"/>';
    echo '<meta itemprop="image" content="' . $og_image . '">';
  }
}
add_action( 'wp_head', __NAMESPACE__ . '\\sage_open_graph_tags', 5 );


/**
 * Favicons
*/
function sage_favicons() {
  echo '<link rel="apple-touch-icon" sizes="180x180" href="' . get_stylesheet_directory_uri() . '/dist/images/favicons/apple-touch-icon.png">';
  echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/dist/images/favicons/favicon-32x32.png" sizes="32x32">';
  echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/dist/images/favicons/favicon-16x16.png" sizes="16x16">';
  echo '<link rel="manifest" href="' . get_stylesheet_directory_uri() . '/dist/images/favicons/manifest.json">';
  echo '<link rel="mask-icon" href="' . get_stylesheet_directory_uri() . '/dist/images/favicons/safari-pinned-tab.svg" color="#002ea2">';
  echo '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri() . '/dist/images/favicons/favicon.ico">';
  echo '<meta name="msapplication-config" content="/favicons/browserconfig.xml">';
  echo '<meta name="theme-color" content="#ffffff">';
}
add_action( 'wp_head', __NAMESPACE__ . '\\sage_favicons', 6 );


/**
 * Google Analytics
*/
function sage_google_analytics() {
  echo "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-CODE-HERE', 'auto'); ga('send', 'pageview');</script>";
}
add_action('wp_footer', __NAMESPACE__ . '\\sage_google_analytics');