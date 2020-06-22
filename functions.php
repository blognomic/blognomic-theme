<?php /*

  This file is part of a child theme called BlogNomic.
  Functions in this file will be loaded before the parent theme's functions.
  For more information, please read
  https://developer.wordpress.org/themes/advanced-topics/child-themes/

*/

// this code loads the parent's stylesheet (leave it in place unless you know what you're doing)

function blognomic_theme_enqueue_styles() {

  $parent_style = 'parent-style';

  wp_enqueue_style( $parent_style,
    get_template_directory_uri() . '/style.css');

  wp_enqueue_style( 'child-style',
    get_stylesheet_directory_uri() . '/style.css',
    array($parent_style),
    wp_get_theme()->get('Version')
  );

  wp_enqueue_style(
    'blognomic-theme-style',
    get_stylesheet_directory_uri() . '/dist/css/blognomic.css',
    ['child-style'],
    wp_get_theme()->get('Version')
  );
}

add_action('wp_enqueue_scripts', 'blognomic_theme_enqueue_styles');

/*  Add your own functions below this line                                                                                                                                                                                                                                                                                                               .
    ======================================== */

// Default the "Admin User" field to the current user.
function blognomic_theme_admin_user_default($field) {
  if(empty($field['value'])) {
    $field['value'] = get_current_user_id();
  }

  return $field;
}
add_filter('acf/load_field/name=admin_user', 'blognomic_theme_admin_user_default');


function blognomic_theme_sidebar_pending_query_alter($query) {
  $query->set('post_status', ['open', 'publish']);
}

add_action('elementor/query/sidebar-pending', 'blognomic_theme_sidebar_pending_query_alter');
