<?php
/* --------------------------------------------------------------------------------------------
 * remove the underscore (_) between Template & Name (line 7) to activate PAGE ARCHIVE template
 * or from Template_Name to Template Name | Change to your template name
 * ----------------------------------------------------------------------------------------- */
/**
 * Template Name: Jakers
 * Description: Change description to what you like
 */


// Do not edit the next 3 lines
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


// Do not edit the next lines, it's where the WP_Query command is processed
include_once( 'swp_template/swp_wp_query.php' );
include_once( 'swp_template/swp_query_entries.php' );


/* --------------------------------------------------------------------------------------------
 * Main Class
 * This name should be unique - rename the class names in the next two lines
 * ----------------------------------------------------------------------------------------- */
$a = new SWPTemplateSample();
class SWPTemplateSample {

	// sample template function
	public function swp_video_archive_function() {

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
		$paged1 = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$post_type 			= 'video';
		$template 			= 'jake.php'; // will default to pre-coded sample_template.php if no value is declared
		$tax_name 			= '';
		$tax_term			= '';
		$posts_per_page 	= 8; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$paged				= $paged1;
		$orderbymeta		= ''; // specify custom field to be ordered by
		$orderby			= ''; // 
		$order				= ''; // ASC or DESC

		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $orderbymeta, $orderby, $order, $template );

	}


	// CONSTRUCT
	public function __construct() {

		if( !is_admin() ) {

			// DISPLAY VIDEO
			add_action( 'genesis_entry_content', array( $this, 'swp_video_archive_function' ) );

		}

	}

}


genesis();