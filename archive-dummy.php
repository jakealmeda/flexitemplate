<?php
/**
 *
 * Template Name: AJAX Archive
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
		// ?template=mediaobject-social.php&tax_name=social_type&tax_term=facebook&posts_per_page=3
		/*
			https://prototype-npr.basestructure.com/social-feed-dummy/?template=mediaobject-social.php&tax_name=social_type&tax_term=instagram&posts_per_page=3&page=2
		*/
		$post_type 			= $_REQUEST[ 'posttype' ];
		$template 			= 'mediaobject-social-ajax.php'; //$_REQUEST[ 'template' ]; // will default to pre-coded sample_template.php if no value is declared
		$tax_name 		    = $_REQUEST[ 'tax_name' ]; //'social_type';
		$tax_term 		    = $_REQUEST[ 'tax_term' ];
		$posts_per_page 	= $_REQUEST[ 'posts_per_page' ]; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$paged 				= (get_query_var('paged')) ? get_query_var('paged') : 1;
		$show_entries		= $_REQUEST[ 'showentries' ];
		$skip				= $_REQUEST[ 'skip' ];
		$display			= $_REQUEST[ 'display' ];

		echo "Post type: ".$post_type.'<br />';
		echo "Template: ".$template.'<br />';
		echo "Tax Name: ".$tax_name.'<br />';
		echo "Tax Term: ".$tax_term.'<br />';
		echo "PPP: ".$posts_per_page.'<br />';
		echo "Page: ".$paged.'<br />';
		echo "Show Entries: ".$showentries.'<br />';
		echo "Skip: ".$skip.'<br />';
		echo "Display: ".$display.'<br />';

		$more = array(
					'tag-open'		=> '<div class="grid-third gap-lrg" id="grid-container">', // opening container tag here
					'tag-close'		=> '</div>', // closing container tag here
					'skip'			=> $skip,
					'display'		=> $display,
					'show_entries'	=> $show_entries,
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