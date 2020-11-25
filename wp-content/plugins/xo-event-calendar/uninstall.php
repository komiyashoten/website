<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

function xo_event_calendar_uninstall() {
	global $wpdb;
	global $wp_taxonomies;

	if ( ( $uninstall_options = get_site_transient( 'xo_event_calendar_uninstall_options' ) ) ) {
		$post_type = $uninstall_options[0];
		$taxonomy_type = $uninstall_options[1];

		register_taxonomy( $taxonomy_type );
		$terms = get_terms( $taxonomy_type, array( 'hide_empty' => false ) );
		if ( $terms ) {
			foreach ( $terms as $term ) {
				$term_id = (int)$term->term_id;
				delete_option( 'xo_event_calendar_cat_' . $term_id );
				delete_site_option( 'xo_event_calendar_cat_' . $term_id );
				wp_delete_term( $term_id, $term->taxonomy );
			}
		}
		unset( $wp_taxonomies[$taxonomy_type] );

		$posts_table = $wpdb->posts;
		$query = "DELETE FROM {$posts_table} WHERE post_type = '{$post_type}';";
		$wpdb->query( $query );

		delete_site_transient( 'xo_event_calendar_uninstall_options' );
	}

	delete_option( 'xo_event_calendar_options' );
	delete_site_option( 'xo_event_calendar_options' );
	delete_option( 'xo_event_calendar_holiday_settings' );
	delete_site_option( 'xo_event_calendar_holiday_settings' );
}

xo_event_calendar_uninstall();
