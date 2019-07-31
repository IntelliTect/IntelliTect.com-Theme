<?php
/**
 * The template for displaying case study posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>


<?php
    $services = get_field('list_of_services');
    if (strlen($services) > 1) {
        $services = array_map('trim', explode('<br />', $services));
    }

    $about_target_name = get_field('about_target_name');
    $about_target_description = get_field('about_target_description');
    $pdf_link = get_field('full_pdf');
    $industries = wp_get_post_terms($post->ID, 'searchable_industries');
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main case-studies-single">

			<aside class="pcsd-sidebar">
			<?php if (!empty($about_target_name) && !empty($about_target_description)):?>
				<section class="pcsd-sidebar-section section-about">
						<div class="pcsd-sidebar-header">About <?php echo $about_target_name; ?></div>
						<?php echo $about_target_description; ?>
				</section>
			<?php endif; // end about section ?>

			<?php if (count($services) >= 1): ?>
				<section class="pcsd-sidebar-section section-services">
					<div class="pcsd-sidebar-header">Products &amp; Services Used</div>
					<ul>
						<?php foreach ($services as $service):?>
							<li><?php echo $service ?></li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; // end services section ?>

			<?php if (!empty($industries)): ?>
				<section class="pcsd-sidebar-section section-industries">
					<div class="pcsd-sidebar-header">Industries:</div>
					<ul>
						<?php foreach ($industries as $industry):?>
							<li><?php echo $industry->name ?></li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>

			<?php if (!empty($pdf_link)): ?>
				<section class="pcsd-sidebar-section section-pdf">
					<a target="_blank" href="<?php echo $pdf_link; ?>">Download Case Study</a>
				</section>
			<?php endif; // end pdflink ?>

			</aside>


			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'single' );

				if ( is_singular( 'attachment' ) ) {
					// Parent post navigation.
					the_post_navigation(
						array(
							/* translators: %s: parent post link */
							'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentynineteen' ), '%title' ),
						)
					);
				} elseif ( is_singular( 'post' ) ) {
					// Previous/next post navigation.
					the_post_navigation(
						array(
							'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'twentynineteen' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Next post:', 'twentynineteen' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
							'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'twentynineteen' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Previous post:', 'twentynineteen' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
						)
					);
				}

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
