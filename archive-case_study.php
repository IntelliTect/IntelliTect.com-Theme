<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

$all_industries = get_terms( array(
    'taxonomy' => 'searchable_industries',
    'hide_empty' => false,
) );

$all_services = get_terms( array(
    'taxonomy' => 'searchable_services',
    'hide_empty' => false,
) );

if ($_POST['action'] == 'Show All') {
    $search = '';
    $industries = array();
    $services = array();
} else {
    $search = sanitize_text_field($_POST['search_stories']);
    $industries = isset($_POST['industries']) ? (array)$_POST['industries'] : array();
    $industries = array_filter($industries); // removes empty entries
    $industries = array_map('sanitize_key', $industries);
    $services =  isset($_POST['services']) ? (array)$_POST['services'] : array();
    $services = array_filter($services); // removes empty entries
    $services = array_map('sanitize_key', $services);
}

?>

<?php
add_filter('is_active_sidebar', function() { return false; });

get_header();
?>


<section id="primary" class="content-area">
	<main id="main" class="site-main entry">

		<header class="entry-header">
			<h1 class="entry-title">
				Case Studies
			</h1>
		</header>

		<div class="entry-content wide-content case-studies-archive">
			<form class="case-studies-search-form" method="POST" action="">
				<div class="case-studies-tax-filters" style="display: flex">

					<div class="s-industry-container">
						<label for="industries[]">Filter Industries:</label>
						<select class="s-industry" name="industries[]" id="cs-search-industry" multiple="multiple">
							<?php foreach ($all_industries as $industry):?>

								<option
									value="<?php echo $industry->slug; ?>"
									<?php echo (in_array($industry->slug, $industries) ? 'selected' : ''); ?>
								><?php echo $industry->name; ?></option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="s-service-container">
						<label for="services[]">Filter Services:</label>
						<select class="s-service" name="services[]" id="cs-search-service" multiple="multiple">
							<?php foreach ($all_services as $service):?>
								<option
									value="<?php echo $service->slug; ?>"
									<?php echo (in_array($service->slug, $services) ? 'selected' : ''); ?>
								><?php echo $service->name; ?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>

				<div class="search_stories_box" style="display: flex;margin-bottom: 20px;">
					<input
						type="text"
						id="search_stories"
						name="search_stories"
						value="<?php echo (isset($_POST['search_stories']) && $_POST['search_stories'] ? $_POST['search_stories']  :"");?>" placeholder="Search"
						style="max-width: 100%; flex-grow: 1; margin-right: 20px;"/>
					<input type="submit" name="action" value="GO"/>
					<?php if (!empty($search) || !empty($services) || !empty($industries)): ?>
						<input type="submit" name="action" value="Show All" style="margin-left: 20px;"/>
					<?php endif ?>
				</div>

			</form>

			<div class="">

				<div class="case-studies">

					<?php

						$posts_per_page = 500;
						//    $data_to_order_by = 'post_title';
						$column_to_order_by = 'post_date_gmt';
						$order_direction = 'DESC';

						$qParamsRegularSearch = array(
							'post_type' => 'case_study',
							'posts_per_page' => $posts_per_page,
							'no_paging' => 'true',
							's' => $search,
							'orderby' => $column_to_order_by,
							'order'   => $order_direction,
						);


						$qParams = $qParamsRegularSearch;

						$taxonomyQueryParams = array();
						$taxQueryServ = array();
						if (!empty($services)){
							$taxQueryServ = array(
									array(
										'taxonomy'=>'searchable_services',
										'field' => 'slug',
										'terms' => $services,
										'operator' => 'AND'
									)
							);
						}
						$taxQueryInd = array();
						if (!empty($industries)){
							$taxQueryInd = array(
								array(
									'taxonomy'=>'searchable_industries',
									'field' => 'slug',
									'terms' => $industries,
									'operator' => 'AND'
								)
							);
						}
						if (!empty($taxQueryInd) && !empty($taxQueryServ)) {
							$taxonomyQueryParams = array('relation' => 'AND');

						}
						if(!empty($taxQueryInd)){
							$taxonomyQueryParams[] = $taxQueryInd;
						}
						if(!empty($taxQueryServ)){
							$taxonomyQueryParams[] = $taxQueryServ;
						}
						if (!empty($taxonomyQueryParams)) {
							$qParams['tax_query'] = $taxonomyQueryParams;
						}

						$result = new WP_Query($qParams);

						$i = 0;
						if ($result->have_posts()) :
							while ($result->have_posts()) :
								$result->the_post();
								?>
								<div class="case-studies-item__wrap">
									<a href="<?php echo get_permalink() ?>">
										<div class="case-studies-item__main">
											<div class="case-studies-item__image-wrap">
												<?php the_post_thumbnail('post-thumbnail', ['width' => '390', 'height' => '219']); ?>
											</div>
											<div class="case-studies-item__title-wrap">
												<h5 class="case-studies-item__title">
													<?php the_title(); ?>
												</h5>
											</div>
										</div>
									</a>
								</div>


							<?php endwhile; ?>

							<?php wp_reset_postdata(); ?>

						<?php else: ?>

							<p>Sorry, no case studies matched your criteria.</p>

						<?php
						endif;
					?>

				</div>
			</div>
		</div>

	</main>
</section>

<div class="clear"></div>

<?php get_footer(); ?>
