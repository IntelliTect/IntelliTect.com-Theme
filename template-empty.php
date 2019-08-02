<?php
/**
 * Template Name: IntelliTect Blank
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
			while ( have_posts() ) {
				the_post();
		?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_content(); ?>
			</article><!-- #post-${ID} -->
		<?php
			}
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php
get_footer();
