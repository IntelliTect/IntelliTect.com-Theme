<?php


function team_custom_post_type() {

// Register post type and taxonomy
register_post_type( "cpt_team", array(
	'label'               => 'Team',
	'description'         => 'Team Description',
	'labels'              => array(
		'name'                => 'Team',
		'singular_name'       => 'Team member',
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
	'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
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

}

add_action('init', 'team_custom_post_type', 0);
