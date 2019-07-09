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


/* --------------------------------------------------------------------------------------------
 * Main Class
 * The Class name should be unique - rename the class names in the next two lines
 * ----------------------------------------------------------------------------------------- */
$a = new SWPTemplateSample();
class SWPTemplateSample {
	
	// NEXT
	public function swp_next() {

		// do not edit the next line
		$b = new SWP_QueryEntries();

		$post_type 			= 'video';
		$template 			= 'single_sample_template.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$current_post_id 	= get_the_ID();

		// WHAT TO SHOW
		$show = "next";

		$out = $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );

		if( $out ) {
			// opening container tag here
			echo $out;
			// closing container tag here
		}

	}
	
	// PREVIOUS
	public function swp_prev() {

		// do not edit the next line
		$b = new SWP_QueryEntries();

		$post_type 			= 'video';
		$template 			= 'single_sample_template.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$current_post_id 	= get_the_ID();

		// WHAT TO SHOW
		$show = "previous";

		$out = $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );

		if( $out ) {
			// opening container tag here
			echo $out;
			// closing container tag here
		}

	}
	
	// BOTH
	public function swp_both() {

		// do not edit the next line
		$b = new SWP_QueryEntries();

		$post_type 			= 'video';
		$template 			= 'single_sample_template.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$current_post_id 	= get_the_ID();

		// WHAT TO SHOW
		$show = "both";

		$out = $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );

		if( $out ) {
			// opening container tag here
			echo $out;
			// closing container tag here
		}
		
	}

	// CONSTRUCT
	public function __construct() {

		if( !is_admin() ) {
			add_action( 'genesis_before_sidebar_widget_area', array( $this, 'swp_next' ) );
			add_action( 'genesis_entry_content', array( $this, 'swp_prev' ) );
			//add_action( 'genesis_entry_content', array( $this, 'swp_both' ) );
		}

	}

}


/* --------------------------------------------------------------------------------------------
 * Do not remove the last line | call genesis
 * ----------------------------------------------------------------------------------------- */
genesis();
