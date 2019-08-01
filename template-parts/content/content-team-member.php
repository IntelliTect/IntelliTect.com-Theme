<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<div class="team-member-meta">
			<div class="team-member-image">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>

			<div class="team-member-header">
				<h1 class="entry-title">
					<?php the_title(); ?>
					<span class="team-member-subtitle">
						<?= get_post_meta(get_the_ID(), 'author_title', true) ?>
					</span>
				</h1>
			</div>
		</div>


		<div class="team-member-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'twentynineteen' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
