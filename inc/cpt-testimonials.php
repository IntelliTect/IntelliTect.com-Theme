<?php

function testimonial_custom_post_type() {

	register_post_type( "cpt_testimonials", array(
		'label'               => 'Testimonial',
		'description'         => 'Testimonial Description',
		'labels'              => array(
			'name'                => 'Testimonials',
			'singular_name'       => 'Testimonial',
			'menu_name'           => 'Testimonials',
			'parent_item_colon'   => 'Parent Item:',
			'all_items'           => 'All Testimonials',
			'view_item'           => 'View Testimonial',
			'add_new_item'        => 'Add New Testimonial',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Testimonial',
			'update_item'         => 'Update Testimonial',
			'search_items'        => 'Search Testimonial',
			'not_found'           => 'Not found',
			'not_found_in_trash'  => 'Not found in Trash',
		),
		'supports'            => array( 'title', 'editor', 'thumbnail'),
		'public'              => true,
		'hierarchical'        => false,
		'has_archive'         => false,
		'can_export'          => true,
		'show_in_admin_bar'   => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'exclude_from_search' => true,
		'menu_position'       => '54.0',
		'menu_icon'			  => 'dashicons-format-status',
		'capability_type'     => 'post',
		'rewrite'             => array( 'slug' => 'testimonials' )
		)
	);

	add_filter('twentynineteen_can_show_post_thumbnail', function($show) {
		if (get_post_type() == 'cpt_testimonials') return false;
		return $show;
	});

	add_shortcode('intellitect_testimonials', function($atts) {

		wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js', [], '2.6.10');

		$atts = shortcode_atts( array(
			'count' => 12,
		), $atts, 'intellitect_testimonials' );

		ob_start();
		extract($atts);
		include( locate_template( 'template-parts/shortcodes/testimonials.php', false, false ) );
        return ob_get_clean();
	});
}

add_action('init', 'testimonial_custom_post_type', 0);
