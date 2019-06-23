<?php
// Do not edit the next 3 lines
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class SWP_WPQueryPosts {
	
	public function swp_query_archive_posts( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $orderbymeta, $orderby, $order ) {

		// sort
		if( is_null( $orderby ) ) {
			$orderby = 'date';
			$order = 'DESC';
		}

		// pagination
		if( $paged ) {
			$paged = $paged;
		} else {
			$paged = get_query_var( 'paged' );
		}

		// check posts per page value
		if( is_numeric( $posts_per_page ) ) {
			$posts_per_page = $posts_per_page;
		} else {
			$posts_per_page = get_option('posts_per_page');
		}

		if( $tax_name ) {
			$condition = TRUE;
		} else {
			$condition = FALSE;
		}

		$args = array(
			'post_type' 		=> $post_type,
			'post_status'    	=> 'publish',
			'posts_per_page' 	=> $posts_per_page,
			'paged' 			=> $paged,
			'meta_key'			=> $orderbymeta,
			'orderby'			=> $orderby,
			'order'				=> $order,
		) + ( $condition ? array(
			'tax_query' 		=> array(
				array(
					'taxonomy' 		=> $tax_name,
					'field'    		=> 'slug',
					'terms'    		=> $tax_term,
				),
		)) : array());

		return new WP_Query( $args );

	}

}