
<?php

function case_studies_custom_post_type() {
    $labels = array(
        'name' => _x('Case Studies', 'Post Type General Name', 'text_domain'),
        'singular_name' => _x('Case Study', 'Post Type Singular Name', 'text_domain'),
        'menu_name' => __('Case Studies', 'text_domain'),
        'parent_item_colon' => __('Parent Item:', 'text_domain'),
        'all_items' => __('Case Studies', 'text_domain'),
        'view_item' => __('View Case Study', 'text_domain'),
        'add_new_item' => __('Add New Case Study', 'text_domain'),
        'add_new' => __('Add New', 'text_domain'),
        'edit_item' => __('Edit Case Study', 'text_domain'),
        'update_item' => __('Update Case Study', 'text_domain'),
        'search_items' => __('Search Case Study', 'text_domain'),
        'not_found' => __('Not found', 'text_domain'),
        'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
    );
    $args = array(
        'label' => __('case_study', 'text_domain'),
        'description' => __('Case Study Description', 'text_domain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('client_name', 'post_tag'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'case-studies' )
    );
    register_post_type('case_study', $args);

    register_taxonomy(
        'searchable_services',
        'case_study',
        array(
            'labels' => array(
                'name' => _x( 'Searchable Services', 'taxonomy general name', 'intellitect-text-domain'),
                'singular_name' => _x('Searchable service', 'taxonomy singular name', 'intellitect-text-domain'),
                'all_items' => __('All Searchable Services', 'intellitect-text-domain'),
                'edit_item' => __('Edit Searchable Service', 'intellitect-text-domain'),
                'view_item' => __('View Searchable Service', 'intellitect-text-domain'),
                'update_item' => __('Update Searchable Service', 'intellitect-text-domain'),
                'add_new_item' => __('Add New Searchable Service', 'intellitect-text-domain'),
                'new_item_name' => __('New Searchable Service', 'intellitect-text-domain'),
                'parent_item' => __('Parent Searchable Service', 'intellitect-text-domain'),
                'search_items' => __('Search Searchable Services', 'intellitect-text-domain'),
                'popular_items' => __('Popular Searchable Service', 'intellitect-text-domain')
            ),
            'hierarchical' => true,
			'show_admin_column' => true,
        )
    );

    register_taxonomy(
        'searchable_industries',
        'case_study',
        array(
            'labels' => array(
                'name' => _x( 'Searchable Industries', 'taxonomy general name', 'intellitect-text-domain'),
                'singular_name' => _x('Searchable Industry', 'taxonomy singular name', 'intellitect-text-domain'),
                'all_items' => __('All Searchable Industries', 'intellitect-text-domain'),
                'edit_item' => __('Edit Searchable Industry', 'intellitect-text-domain'),
                'view_item' => __('View Searchable Industry', 'intellitect-text-domain'),
                'update_item' => __('Update Searchable Industry', 'intellitect-text-domain'),
                'add_new_item' => __('Add New Searchable Industry', 'intellitect-text-domain'),
                'new_item_name' => __('New Searchable Industry', 'intellitect-text-domain'),
                'parent_item' => __('Parent Searchable Industry', 'intellitect-text-domain'),
                'search_items' => __('Search Searchable Industries', 'intellitect-text-domain'),
                'popular_items' => __('Popular Searchable Industries', 'intellitect-text-domain')
            ),
            'hierarchical' => true,
			'show_admin_column' => true,
        )
    );
}

// Hook into the 'init' action
add_action('init', 'case_studies_custom_post_type', 0);




function get_index_of_cases() {
    global $wpdb;

    $rand_posts = $wpdb->get_results(
        "SELECT ID, post_title, post_status, post_type FROM `wp_posts` WHERE post_type = 'case_study' AND post_status = 'publish' ORDER BY post_date_gmt DESC"
    );

    $case_studies = array();

    foreach ($rand_posts as $key => $rand) {
      $title = $rand->post_title;
      $id = $rand->ID;
      $case_studies[$key]['ID'] = $id;
      $case_studies[$key]['title'] = $title;
    }
    return $case_studies;
}
