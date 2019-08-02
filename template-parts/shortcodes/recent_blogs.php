

<div class="recent-blogs">
<?php

$result = new WP_Query(array(
	"category_name" => $category,
	"posts_per_page" => $count,
));


if ($result->have_posts()) :
	while ($result->have_posts()) :
		$result->the_post();
		?>
		<div class="recent-blog-item__wrap">
			<a href="<?php echo get_permalink() ?>">
				<div class="recent-blog-item__main">
					<div class="recent-blog-item__image-wrap">
						<?php the_post_thumbnail('post-thumbnail'); ?>
					</div>
					<div class="recent-blog-item__title-wrap">
						<h5 class="recent-blog-item__title">
							<?php the_title(); ?>
						</h5>
					</div>
				</div>
			</a>
		</div>


	<?php endwhile; ?>

	<?php wp_reset_postdata(); ?>

<?php
endif;
?>
</div>
