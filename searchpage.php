<?php
/**
 * Template Name: Search Page
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="entry">
				<header class="entry-header">
					<h1 class="entry-title">Search</h1>
				</header><!-- .page-header -->

				<div class="entry-content">
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</div><!-- .error-404 -->

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
