<?php

add_theme_support('menus');

add_theme_support('post-thumbnails');

if (function_exists('acf_add_options_page')) {
	acf_add_options_page();
}

add_action('wp_enqueue_scripts', 'teachme_scripts');

function teachme_scripts() {
	wp_enqueue_style( 'style-teachme', get_template_directory_uri() . '/assets/css/style.css' );
	wp_enqueue_script( 'script-teachme', get_template_directory_uri() . '/assets/js/jquery-3.6.4.min.js', array(), null, true );
}

add_action('wp_ajax_load_more', 'load_more');
add_action('wp_ajax_nopriv_load_more', 'load_more');

function load_more() {
  $ajaxposts = new WP_Query([
    'posts_per_page' => 0,
    'paged' => $_POST['paged']
  ]);

  $response = '';

  if ($ajaxposts->have_posts()) {
    while ($ajaxposts->have_posts()) {
			$ajaxposts->the_post();

      $response .= get_template_part('parts/post');
		}
  } else {
    $response = '';
  }

  echo $response;
  exit;
}