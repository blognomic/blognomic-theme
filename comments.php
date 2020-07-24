<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Comment Reply Script.
if ( comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}


$context = Timber::context();
$context['post'] = Timber::get_post();
$context['comments'] = $context['post']->get_comments();
$context['comments_open'] = comments_open();
$context['post_type_supports_comments'] = post_type_supports( get_post_type(), 'comments' );

Timber::render( 'comments.twig', $context );

?>
