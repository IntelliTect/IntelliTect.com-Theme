<?php

$postType = get_post_type();
$obj = get_post_type_object( $postType );
$name = $obj->labels->singular_name;

the_post_navigation(
	array(
		'next_text' => '<span class="meta-nav" aria-hidden="true">Next ' . $name . '</span> ' .
			'<span class="screen-reader-text">Next ' . $name . '</span> <br/>' .
			'<span class="post-title">%title</span>',
		'prev_text' => '<span class="meta-nav" aria-hidden="true">Previous ' . $name . '</span> ' .
			'<span class="screen-reader-text">Previous ' . $name . '</span> <br/>' .
			'<span class="post-title">%title</span>',
	)
);
