<?php
/**
 *
 * Template Name: Social Dummy
 *
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
include_once( get_stylesheet_directory() . '/swp_template/swp_wp_query.php' );
include_once( get_stylesheet_directory() . '/swp_template/swp_query_entries.php' );


/* --------------------------------------------------------------------------------------------
 * Main Class
 * The Class name should be unique - rename the class names in the next two lines
 * ----------------------------------------------------------------------------------------- */
$a = new SWPTemplateSample();
class SWPTemplateSample {

	// sample template function
	public function swp_social_page_dummy_func() {
		
		// required global variables
        global $post, $wp_query;

		// initialize query class
		$b = new SWP_QueryEntries();

		$post_type 			= 'social';
		$template 			= $_REQUEST[ 'template' ]; //'mediaobject-social.php'; // will default to pre-coded sample_template.php if no value is declared
		$tax_name 		    = $_REQUEST[ 'tax_name' ]; //'social_type';
		$tax_term 		    = $_REQUEST[ 'tax_term' ];
		$posts_per_page 	= $_REQUEST[ 'posts_per_page' ]; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$iset				= $_REQUEST[ 'iset' ]; // what social type set are we
		$paged 				= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

/*
		echo "Template: ".$template.'<br />';
		echo "Tax Name: ".$tax_name.'<br />';
		echo "Tax Term: ".$tax_term.'<br />';
		echo "PPP: ".$posts_per_page.'<br />';
		echo "Paged: ".$paged.'<hr>';
*/

		$more = array(
					'tag-open'		=> '<div id="term_set_container"><div class="grid-third gap-lrg" id="term_set_cont_'.$iset.'_'.$paged.'" style="display:none;">', // opening container tag here
					'tag-close'		=> '</div></div>', // closing container tag here
				);
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );
		
		// reset WP_Query
		$b->swp_reset_query();

	}

	// CONSTRUCT
	public function __construct() {

		if( !is_admin() ) {

			// DISPLAY IN CONTENT AREA
			add_action( 'genesis_entry_content', array( $this, 'swp_social_page_dummy_func' ) );

		}

	}

}


/* --------------------------------------------------------------------------------------------
 * Do not remove the last line | call genesis
 * ----------------------------------------------------------------------------------------- */
genesis();