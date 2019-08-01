<?php
/**
 * The template for displaying team member pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main entry team-single">

			<?php

			/* Start the Loop */
			// while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'team-member' );

				// Previous/next post navigation.
				the_post_navigation(
					array(
						'next_text' => '<span class="meta-nav" aria-hidden="true">Next</span> ' .
							'<span class="screen-reader-text">Next Team Member</span> <br/>' .
							'<span class="post-title">%title</span>',
						'prev_text' => '<span class="meta-nav" aria-hidden="true">Previous</span> ' .
							'<span class="screen-reader-text">Previous Team Member</span> <br/>' .
							'<span class="post-title">%title</span>',
					)
				);

			// endwhile; // End of the loop.


		$author = get_post_meta(get_the_ID(), 'user', true);
		$firstName = get_post_meta(get_the_ID(), 'first_name', true);

		if ($author) {
			$page = get_query_var( 'paged', 1 );
			$args = array( 'author' => $author, 'posts_per_page' => 5, 'paged' => $page );
			$authors_posts = query_posts($args);

			if ( have_posts() ):
			?>

			<div class="entry">
				<h2 class="entry-header ">
					Blogs by <?= $firstName ?>
				</h2>
			</div>
			<?php
			endif;
			?>
				<div class="posts_container">
					<?php
						while ( have_posts() ) :
							the_post();

							/*
							* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/
							get_template_part( 'template-parts/content/content', 'excerpt-no-image' );

						endwhile;

						// Previous/next page navigation.
						twentynineteen_the_posts_navigation();

					?>

				</div>
			<?php

			wp_reset_query();
		}
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
