<?php

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'topFeature',
    array(
      'labels' => array(
        'name' => __( 'TOPページ' ),
        'singular_name' => __( 'topFeature' )
      ),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 4,
		'supports' => array('title','editor','thumbnail','custom-fields','excerpt','author','trackbacks','comments','revisions','page-attributes'),
		'has_archive' => true

    )
  );
	register_taxonomy(
		'topFeature-cat', 
		'topFeature', 
		array(
		  'hierarchical' => true, 
		  'update_count_callback' => '_update_post_term_count',
		  'label' => 'カテゴリー',
		  'singular_label' => 'カテゴリー',
		  'public' => true,
		  'show_ui' => true
		)
	);
	
	flush_rewrite_rules( false );
}