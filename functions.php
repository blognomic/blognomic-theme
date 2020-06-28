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

// Filter the human_time_diff function so that it's a little more useful for BlogNomic.
// Moves hours -> days boundary to 48 hours rather than 24, as 48 is usually more relevant to us.
function blognomic_theme_less_misleading_human_time_diff($since, $diff, $from, $to) {
  if(empty($to)) {
    $to = time();
  }
  
  $diff = (int) abs( $to - $from );
  
  if ( $diff < MINUTE_IN_SECONDS ) {
    $secs = $diff;
    if ( $secs <= 1 ) {
        $secs = 1;
    }
    $since = sprintf( _n( '%s second', '%s seconds', $secs ), $secs );
  } elseif ( $diff < HOUR_IN_SECONDS && $diff >= MINUTE_IN_SECONDS ) {
    $mins = floor( $diff / MINUTE_IN_SECONDS );
    if ( $mins <= 1 ) {
        $mins = 1;
    }
    $since = sprintf( _n( '%s min', '%s mins', $mins ), $mins );
  } elseif ( $diff < DAY_IN_SECONDS * 2 && $diff >= HOUR_IN_SECONDS ) {
    $hours = floor( $diff / HOUR_IN_SECONDS );
    if ( $hours <= 1 ) {
        $hours = 1;
    }
    $since = sprintf( _n( '%s hour', '%s hours', $hours ), $hours );
  } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS * 2 ) {
    $days = floor( $diff / DAY_IN_SECONDS );
    if ( $days <= 1 ) {
        $days = 1;
    }
    $since = sprintf( _n( '%s day', '%s days', $days ), $days );
  } elseif ( $diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
    $weeks = floor( $diff / WEEK_IN_SECONDS );
    if ( $weeks <= 1 ) {
        $weeks = 1;
    }
    $since = sprintf( _n( '%s week', '%s weeks', $weeks ), $weeks );
  } elseif ( $diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS ) {
    $months = floor( $diff / MONTH_IN_SECONDS );
    if ( $months <= 1 ) {
        $months = 1;
    }
    $since = sprintf( _n( '%s month', '%s months', $months ), $months );
  } elseif ( $diff >= YEAR_IN_SECONDS ) {
    $years = floor( $diff / YEAR_IN_SECONDS );
    if ( $years <= 1 ) {
        $years = 1;
    }
    $since = sprintf( _n( '%s year', '%s years', $years ), $years );
  }
  
  return $since;
}

add_filter('human_time_diff', 'blognomic_theme_less_misleading_human_time_diff');
