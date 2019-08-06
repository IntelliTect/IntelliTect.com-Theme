<?php


function team_custom_post_type() {
	// flush_rewrite_rules( false ); // for debugging

	// Register post type and taxonomy
	register_post_type( "cpt_team", array(
		'label'               => 'Team',
		'description'         => 'Team Description',
		'labels'              => array(
			'name'                => 'Team',
			'singular_name'       => 'Team Member',
			'menu_name'           => 'Team',
			'parent_item_colon'   => 'Parent Item:',
			'all_items'           => 'All Team',
			'view_item'           => 'View Team member',
			'add_new_item'        => 'Add New Team member',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Team member',
			'update_item'         => 'Update Team member',
			'search_items'        => 'Search Team member',
			'not_found'           => 'Not found',
			'not_found_in_trash'  => 'Not found in Trash',
		),
		'supports'            => array( 'title', 'editor', 'thumbnail'),
		'public'              => true,
		'hierarchical'        => false,
		'has_archive'         => true,
		'can_export'          => true,
		'show_in_admin_bar'   => true,
		'show_in_menu'        => true,
		'menu_position'       => '53.8',
		'menu_icon'			  => 'dashicons-admin-users',
		'capability_type'     => 'post',
		'rewrite'             => array( 'slug' => 'team' )
		)
	);

	add_filter('twentynineteen_can_show_post_thumbnail', function($show) {
		if (get_post_type() == 'cpt_team') return false;
		return $show;
	});

	add_filter( 'get_next_post_where', 'team_get_next_post_where_callback' );
	add_filter( 'get_previous_post_where', 'team_get_previous_post_where_callback' );
}

add_action('init', 'team_custom_post_type', 0);

// Don't redirect team member pages so that pagination information doesn't get
// stripped off of the URL for pagination of blog posts.
// https://wordpress.stackexchange.com/questions/143812/wp-query-pagination-on-single-custom-php
function team_member_redirect() {
    if(is_singular('cpt_team')) {
        remove_action('template_redirect', 'redirect_canonical');
    }
}
add_action('template_redirect', 'team_member_redirect', 0);

// From author pages, redirect to the cpt_team page for the person
// if the person has a cpt_team page with the correct 'user' meta field.
add_action( 'template_redirect', function() {
    if ( is_author() ) {
		$id = get_query_var( 'author' );

		$team_pages = new WP_Query(array(
			'post_type' => 'cpt_team',
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'user',
					'value' => $id,
					'compare' => '=',
				)
			)
		));

		if ( $team_pages->have_posts() ) {
			wp_redirect(get_permalink($team_pages->post->ID));
			die;
		}
    }
});


/* PREV/NEXT Links ordered by last_name. Used in team page */

function get_ordered_team_members() {
	global $wpdb;
	return $wpdb->get_results(
		"select id, post_title, last_name.meta_value as last_name, is_lead.meta_value as is_lead, lead_order.meta_value as lead_order from {$wpdb->posts}
		left join {$wpdb->postmeta} as last_name on last_name.post_id = {$wpdb->posts}.id and last_name.meta_key = 'last_name'
		left join {$wpdb->postmeta} as first_name on first_name.post_id = {$wpdb->posts}.id and first_name.meta_key = 'first_name'
		left join {$wpdb->postmeta} as is_lead on is_lead.post_id = {$wpdb->posts}.id and is_lead.meta_key = 'lead' and is_lead.meta_value = '1'
		left join {$wpdb->postmeta} as lead_order on lead_order.post_id = {$wpdb->posts}.id and lead_order.meta_key = 'lead_order' and is_lead.meta_value = '1'
		where post_type = 'cpt_team' and (post_status = 'publish')
		order by is_lead.meta_value desc, lead_order.meta_value asc, last_name.meta_value asc, first_name.meta_value asc");
}

function team_get_previous_post_where_callback( $where ){
	global $post;
	if ($post->post_type != 'cpt_team') return $where;

	$orderedTeamMembers = get_ordered_team_members();
	$prev = null;
	foreach ( $orderedTeamMembers as $row )
	{
		if ($row->id == $post->ID) {
			if (!$prev) {
				// No prev post exists.
				return 'WHERE 0=1';
			}
			return "WHERE p.id = " . $prev->id;
		}
		$prev = $row;
	}

	return 'WHERE 0=1';
}

function team_get_next_post_where_callback( $where ){
	global $post;
	if ($post->post_type != 'cpt_team') return $where;

	$orderedTeamMembers = get_ordered_team_members();
	$returnNext = false;
	foreach ( $orderedTeamMembers as $row )
	{
		if ($returnNext) {
			return "WHERE p.id = " . $row->id;
		}
		if ($row->id == $post->ID) {
			$returnNext = true;
		}
	}
	// No next post exists.
	return 'WHERE 0=1';
}
