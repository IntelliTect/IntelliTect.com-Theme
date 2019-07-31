<?php
/**
 * The template for displaying archive pages
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
		<main id="main" class="site-main entry ">


		<header class="entry-header">
			<h1 class="entry-title">
			Our Team
			</h1>
		</header>
		<div class="team-archive">

			<?php
				$queries = array(

					"lead" => array(
					// Attention! Parameter 'suppress_filters' is damage WPML-queries!
					//	'suppress_filters' => true,
						'post_type' => "cpt_team",
						'post_status' => 'publish',
						'meta_query' => array(
							'relation' => 'OR',
							'is_lead' => array(
								'key' => 'lead',
								'compare' => '=',
								'value' => "1"
							)
						),
						'meta_key'			=> 'lead_order',
						'orderby'			=> 'meta_value',
						'posts_per_page'    => -1,
						'order'				=> 'ASC',
						'ignore_sticky_posts' => true,
					),
					"normal" => array(
						// Attention! Parameter 'suppress_filters' is damage WPML-queries!
						//	'suppress_filters' => true,
						'post_type' => "cpt_team",
						'post_status' => 'publish',
						'meta_query' => array(
							'relation' => 'OR',
							'not_lead' => array(
								'key' => 'lead',
								'compare' => '!=',
								'value' => "1"
							),
							'not_exist_lead' => array(
								'key' => 'lead',
								'compare' => "NOT EXISTS"
							)
						),
						'meta_key'			=> 'last_name',
						'orderby'			=> 'meta_value',
						'order'				=> 'ASC',
						'posts_per_page'    => -1,
						'ignore_sticky_posts' => true,
					)
				);

			foreach ($queries as $class => $query_args):
				$query = new WP_Query( $query_args );

				if ( $query->have_posts() ): ?>

					<div class="team-members <?= $class ?>">

					<?php
					// Start the Loop.
					while ( $query->have_posts() ) :
						$query->the_post();
						$link = get_permalink();
						$subtitle = get_post_meta(get_the_ID(), 'author_title', true);
					?>

						<div class="team-member">

							<div class="team-member__image">
								<a class="post-thumbnail-inner"
									href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
									<?php the_post_thumbnail( 'post-thumbnail' ); ?>
								</a>
							</div>

							<div class="team-member__text">
								<h4 class="team-member__title"><?php
									if (!empty($link)) {
										?><a href="<?php echo esc_url($link); ?>"><?php
									}
									the_title();
									if (!empty($link)) {
										?></a><?php
									}
								?></h4>
								<div class="team-member__position"><?php echo $subtitle ?></div>
							</div>
						</div>
						<?php

						/*
						* Include the Post-Format-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						// get_template_part( 'template-parts/content/content', 'excerpt' );

						// End the loop.
					endwhile;
				?> </div> <?php
					// If no content, include the "No posts found" template.
				else :
					get_template_part( 'template-parts/content/content', 'none' );

				endif;
			endforeach;
			?>

		</div>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
