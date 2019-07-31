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

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
