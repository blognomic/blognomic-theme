<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */
?>

<?php if($post->post_type === 'post'): ?>
  <?php
		$context = Timber::get_context();
		$post = Timber::query_post();
		$context['post'] = $post;

		if ( post_password_required( $post->ID ) ) {
			Timber::render( 'single-password.twig', $context );
		} else {
			Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
		}
	?>
<?php else: ?>
	<?php
		if ( ! defined( 'ABSPATH' ) ) {
			exit; // Exit if accessed directly.
		}
	?>
	<?php	while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<main <?php post_class( 'site-main' ); ?> role="main">
			<div class="page-content">
				<?php the_content(); ?>
				<div class="post-tags">
					<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
				</div>
				<?php wp_link_pages(); ?>
			</div>

			<?php comments_template(); ?>
		</main>

	<?php	endwhile; ?>
<?php endif; ?>
