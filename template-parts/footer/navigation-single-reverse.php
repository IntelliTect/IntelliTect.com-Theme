<?php

$postType = get_post_type();
$obj = get_post_type_object( $postType );
$name = $obj->labels->singular_name;

# https://gist.github.com/jaredchu/3e3bcb866240d1d32a3b4ae55905b135#file-the_reverse_post_navigation
function the_reverse_post_navigation( $args = array() ) {
    $args = wp_parse_args( $args, array(
        'prev_text'          => '%title',
        'next_text'          => '%title',
        'in_same_term'       => false,
        'excluded_terms'     => '',
        'taxonomy'           => 'category',
        'screen_reader_text' => __( 'Post navigation' ),
    ) );

    $navigation = '';

    $previous = get_next_post_link(
        '<div class="nav-previous">%link</div>',
        $args['prev_text'],
        $args['in_same_term'],
        $args['excluded_terms'],
        $args['taxonomy']
    );

    $next = get_previous_post_link(
        '<div class="nav-next">%link</div>',
        $args['next_text'],
        $args['in_same_term'],
        $args['excluded_terms'],
        $args['taxonomy']
    );

    // Only add markup if there's somewhere to navigate to.
    if ( $previous || $next ) {
        $navigation = _navigation_markup( $previous . $next, 'post-navigation', $args['screen_reader_text'] );
    }

    echo $navigation;
}

the_reverse_post_navigation(
	array(
		'next_text' => '<span class="meta-nav" aria-hidden="true">Next ' . $name . '</span> ' .
			'<span class="screen-reader-text">Next ' . $name . '</span> <br/>' .
			'<span class="post-title">%title</span>',
		'prev_text' => '<span class="meta-nav" aria-hidden="true">Previous ' . $name . '</span> ' .
			'<span class="screen-reader-text">Previous ' . $name . '</span> <br/>' .
			'<span class="post-title">%title</span>',
	)
);
