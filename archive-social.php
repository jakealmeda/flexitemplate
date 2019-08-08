<?php

/* --------------------------------------------------------------------------------------------
 * Do not edit the next 3 lines
 * ----------------------------------------------------------------------------------------- */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/* --------------------------------------------------------------------------------------------
 * Do not edit the next lines, it's where the WP_Query command is processed
 * ----------------------------------------------------------------------------------------- */
include_once( 'swp_template/swp_wp_query.php' );
include_once( 'swp_template/swp_query_entries.php' );


/* --------------------------------------------------------------------------------------------
 * Add remove_actions here
 * ----------------------------------------------------------------------------------------- */
//remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
/*remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );*/
remove_action( 'genesis_loop', 'genesis_do_loop' );


/* --------------------------------------------------------------------------------------------
 * DISPLAY HEADER
 * ----------------------------------------------------------------------------------------- */
add_action( 'genesis_before_loop', 'swp_social_heading' );
function swp_social_heading() {
	?><div class="fontsize-xlrg fontweight-bold archive-description">Social Media</div><?php
}


/* --------------------------------------------------------------------------------------------
 * Main Class
 * The Class name should be unique - rename the class names in the next two lines
 * ----------------------------------------------------------------------------------------- */
$a = new SWPTemplateSample();
class SWPTemplateSample {

	// sample template function
	public function swp_custom_archive_function() {

		// required global variables
        global $post, $wp_query;

		// initialize query class
		$b = new SWP_QueryEntries();

		$post_type 			= 'social';
		$template 			= 'mediaobject-social.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= 3; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$pagination_temp	= 1;

		$paged 				= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$more = array(
						'tag-open'		=> '<div class="grid-third gap-lrg">', // opening container tag here
						'tag-close'		=> '</div>', // closing container tag here
					);
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );

		// reset WP_Query
		$b->swp_reset_query();

	}

	// CONSTRUCT
	public function __construct() {

		if( !is_admin() ) {

			// DISPLAY IN CONTENT AREA
			add_action( 'genesis_loop', array( $this, 'swp_custom_archive_function' ) );

		}

	}

}


/* --------------------------------------------------------------------------------------------
 * Do not remove the last line | call genesis
 * ----------------------------------------------------------------------------------------- */
genesis();