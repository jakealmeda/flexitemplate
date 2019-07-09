<?php
/* --------------------------------------------------------------------------------------------
 * remove the underscore (_) between Template & Name (line 7) to activate PAGE ARCHIVE template
 * or from Template_Name to Template Name
 * ALSO don't forget to rename the name of this file to something like archive-video.php
 * ----------------------------------------------------------------------------------------- */
/**
 * Template_Name: Change to desired name
 * Description: Change description to what you like
 */


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

	// sample template function
	public function swp_video_archive_function() {

		// do not edit the next line
		$b = new SWP_QueryEntries();

		/*
			// Taxonomy guide
			// ---------------------------------------------------------------- TAGS
			$tax_name 		= 'post_tag'; 
			$tax_term		= 'mtv'; // tag slug
			// ------------------------------------------------------------ CATEGORY
			$tax_name 		= 'category';
			$tax_term		= 'official-video'; // category slug
		*/

		// pagination
		//$paged1 = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		//$paged1 = isset( $_GET['paged'] ) ? (int) $_GET['paged'] : 1;

		$post_type 			= 'video';
		$template 			= 'sample_template.php'; // will default to pre-coded sample_template.php if no value is declared
		$tax_name 			= '';
		$tax_term			= '';
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$paged				= $paged1;
		$orderbymeta		= ''; // specify custom field to be ordered by
		$orderby			= ''; // order by what field (default is date)
		$order				= ''; // ASC or DESC (default is DESC)
		$pagination_temp	= ''; // choose from 1, 2 & 3 (any other value will hide the page nav)
		$pagination_count	= 1;

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

			// DISPLAY IN CONTENT AREA
			add_action( 'genesis_entry_content', array( $this, 'swp_video_archive_function' ) );

		}

	}

}


/* --------------------------------------------------------------------------------------------
 * Do not remove the last line | call genesis
 * ----------------------------------------------------------------------------------------- */
genesis();
