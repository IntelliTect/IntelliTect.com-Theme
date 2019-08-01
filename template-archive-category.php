<?php
/**
 * Template Name: Category Archive
 *
 * A template for displaying an archive of a category. Category is pulled from the slug of the page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

add_filter('twentynineteen_image_filters_enabled', function($f) { return false; } );

get_header();
?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
			global $post;
			$pageTitle = apply_filters( 'the_title', $post->post_title );
			$pageContent = apply_filters( 'the_content', $post->post_content );
			$post_slug = $post->post_name;

			query_posts(array(
				"paged" => get_query_var( 'paged', 1 ),
				"category_name" => $post_slug,
			));

		if ( have_posts() ) : ?>

			<div class="entry">
				<header class="entry-header">
					<h1 class="entry-title">
						<?= $pageTitle  ?>
					</h1>
				</header>
				<?php if ($pageContent): ?>
				<div class="entry-content">
					<?= $pageContent  ?>
				</div>
				<?php endif; ?>
			</div>

			<div class="posts_container">
				<?php
					// Start the Loop.
					while ( have_posts() ) :
						the_post();

						/*
						* Include the Post-Format-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						get_template_part( 'template-parts/content/content', 'excerpt' );

						// End the loop.
					endwhile;

					// Previous/next page navigation.
					twentynineteen_the_posts_navigation();
					?>
			</div>
				<?php

				// If no content, include the "No posts found" template.
				else :
					get_template_part( 'template-parts/content/content', 'none' );

				endif;
			?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
