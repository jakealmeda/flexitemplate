<?php
/**
 *
 * Template Name: Social
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
 * Add remove_actions here
 * ----------------------------------------------------------------------------------------- */
//remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
/*remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
remove_action( 'genesis_loop', 'genesis_do_loop' );
*/

/* --------------------------------------------------------------------------------------------
 * DISPLAY VIDEO HEADER
 * ----------------------------------------------------------------------------------------- */
//add_action( 'genesis_before_loop', 'swp_social_heading' );
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
	public function swp_video_archive_function() {
		
		// required global variables
        global $post, $wp_query;

		// initialize query class
		$b = new SWP_QueryEntries();

		$post_type 			= 'social';
		$template 			= 'mediaobject-social.php'; // will default to pre-coded sample_template.php if no value is declared
		$tax_name 		    = 'social_type';
		$posts_per_page 	= 3; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$pagination_temp	= 'ajax';
		$js_animate			= "slide_right";  

		// hide boxes
		$div_args = ' style="display:none;"';

		// Get taxonomies associated with this post type
		$social_types = get_terms([
				'taxonomy' => $tax_name,
				'hide_empty' => false,
			]);
		
		echo '<input type="text" id="social_types_count" value="'.count($social_types).'" '.$div_args.' />';
		foreach ( $social_types as $term ) {// echo '<li>' . $term->term_id. ' | '. $term->name. ' | '. $term->slug . '</li>';

			$term_counter++;

			// category slug
			$tax_term = $term->slug;

			echo '<div class="fontsize-med fontweight-bold archive-description">'.$term->name.'</div>';
			$more = array(
						'tag-open'		=> '<div id="term_set_'.$term_counter.'"><div class="grid-third gap-lrg" id="term_set_cont_'.$term_counter.'_1">', // opening container tag here
						'tag-close'		=> '</div></div>
											<div '.$div_args.'>
												<input type="text" id="template_'.$term_counter.'" value="'.$template.'" />
												<input type="text" id="tax_name_'.$term_counter.'" value="'.$tax_name.'"/>
												<input type="text" id="tax_term_'.$term_counter.'" value="'.$tax_term.'" />
												<input type="text" id="ppp_'.$term_counter.'" value="'.$posts_per_page.'" />
												<input type="text" id="paged_'.$term_counter.'" />
											</div>', // closing container tag here
						'nav-count'		=> $term_counter,
					);
			echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );
			
			// reset WP_Query
			$b->swp_reset_query();

	    }

	    $templates = $template;

	}

	// LOAD SCRIPTS
	public function swp_load_scripts_func() {

	    // jquery UI
	    if( !wp_script_is( 'jquery-ui-core', 'enqueued' ) ) {
	    	wp_enqueue_script( 'jquery-ui-core' );
	    }

		// fade in/out
	    if( !wp_script_is( 'jquery-effects-fade', 'enqueued' ) ) {
	        wp_enqueue_script( 'jquery-effects-fade' );
	    }

	    // jquery core
	    if( !wp_script_is( 'jquery-effects-core', 'enqueued' ) ) {
	    	wp_enqueue_script( 'jquery-effects-core' );
	    }

	    // jquery Slide
	    if( !wp_script_is( 'jquery-effects-slide', 'enqueued' ) ) {
	    	wp_enqueue_script( 'jquery-effects-slide' );
	    }


		// Register the script
		wp_register_script( 'flexi_temp_ajax', get_stylesheet_directory_uri() . '/swp_template_js/asset.js', array( 'jquery' ), NULL, TRUE );

		// get dummy page URL
        $pagez = get_page_by_path( 'social-feed-dummy' );

		// Localize the script with new data
		$args = array(
			'site_url' => esc_url( get_page_link( $pagez->ID ) ),
		);

		wp_localize_script( 'flexi_temp_ajax', 'flexi_temp_args', $args );

		// Enqueued script with localized data.
		wp_enqueue_script( 'flexi_temp_ajax' );

	}

	// CONSTRUCT
	public function __construct() {

		if( !is_admin() ) {

			// DISPLAY IN CONTENT AREA
			add_action( 'genesis_entry_content', array( $this, 'swp_video_archive_function' ) );

			// LOAD JS SCRIPTS
			add_action( 'wp_enqueue_scripts', array( $this, 'swp_load_scripts_func' ) );

		}

	}

}


/* --------------------------------------------------------------------------------------------
 * Do not remove the last line | call genesis
 * ----------------------------------------------------------------------------------------- */
genesis();