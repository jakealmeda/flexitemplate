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

/*		$out = $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
		// validate $out if has contents and hide container if empty
		if( $out ) {*/
			// opening container tag here
			echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
			// closing container tag here
//		}

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

/*		$out = $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
		// validate $out if has contents and hide container if empty
		if( $out ) {*/
			// opening container tag here
			echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
			// closing container tag here
//		}

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

/*		$out = $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
		// validate $out if has contents and hide container if empty
		if( $out ) {*/
			// opening container tag here
			echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
			// closing container tag here
//		}
		
	}

	// GRID
	public function swp_grid() {

		// do not edit the next line
		$b = new SWP_QueryEntries();

		$post_type 			= 'video';
		$template 			= 'single_sample_template.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		//$paged				= $paged1;
		//$pagination_temp	= ''; // choose from 1, 2 & 3 (any other value will hide the page nav)
		//$pagination_count	= 1;

		// WHAT TO SHOW
		$show = "6";
		$current_post_id 	= get_the_ID();

/*		$out = $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
		// validate $out if has contents and hide container if empty
		if( $out ) {*/
	        echo '<div id="section-podcast-entry-related" class="group archive-grid archive-grid-podcast section-podcast-entry-related">';
    		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
    		echo '</div>';
//		}

	}

	// ORDER BY META VALUE
	public function swp_order_by_metavalue() {
        
		// do not edit the next line
		$b = new SWP_QueryEntries();
        
		$post_type 			= 'video';
		$template 			= 'mediaobject-horizontal.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		//$orderbymeta        = 'meta_value';
		//$paged				= $paged1;
		//$pagination_temp	= ''; // choose from 1, 2 & 3 (any other value will hide the page nav)
		//$pagination_count	= 1;
        
		// WHAT TO SHOW
		$show = "meta";
		$current_post_id 	= get_the_ID();
        
        // IMAGE
        $swp_field = get_post_meta( get_the_ID(), "series", TRUE );
        if ( $swp_field ) {
            
            // set custom field query
            $meta_query = array(
                    array(
                        'key'     => 'series',
                        'value'   => $swp_field,
                        'compare' => '=',
                    ),
                );
        
    		echo '<div class="feature-pretitle">ORDER BY CUSTOM FIELD</div>';
    		echo '<div class="grid-feature grid-2col feature-related">';
    		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
    		echo '</div>';
    		
		}

	}

	// CONSTRUCT
	public function __construct() {

		if( !is_admin() ) {
			add_action( 'genesis_before_sidebar_widget_area', array( $this, 'swp_next' ) );
			add_action( 'genesis_entry_content', array( $this, 'swp_prev' ) );
			//add_action( 'genesis_entry_content', array( $this, 'swp_both' ) );
			add_action( 'genesis_entry_content', array( $this, 'swp_grid' ) );
			add_action( 'genesis_entry_content', array( $this, 'swp_order_by_metavalue' ) );
		}

	}

}


/* --------------------------------------------------------------------------------------------
 * Do not remove the last line | call genesis
 * ----------------------------------------------------------------------------------------- */
genesis();
