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

	// latest article
	public function swp_feature_article_function() {

		// required global variables
        global $post, $wp_query;

		// initialize query class
		$b = new SWP_QueryEntries();

		$post_type 			= 'social';
		$template 			= 'mediaobject-social.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= 1; // will default to "Blog pages show at most" if no value is declared | -1 to show all

//		$paged 				= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$more = array(
						'tag-open'		=> '<div id="feature-article">', // opening container tag here
						'tag-close'		=> '</div>', // closing container tag here
					);
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );

		// reset WP_Query
		$b->swp_reset_query();		

	}

	// sample template function
	public function swp_custom_archive_function() {

		// required global variables
        global $post, $wp_query;

		// initialize query class
		$b = new SWP_QueryEntries();

        // EDIT FROM HERE ------------------------
		$post_type 			= 'social';
		$template 			= 'mediaobject-social.php'; // will default to pre-coded sample_template.php if no value is declared
		$show_entries		= 6;
		$skip				= 1;
		// EDIT TILL HERE ONLY -------------------
		
		// do not edit the next few lines
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$display 			= 'hackloop';
		$div_args 			= ' style="display:none;"';

		$more = array(
						'tag-open'		=> '<div class="grid-third gap-lrg" id="grid-container">', // opening container tag here
						'tag-close'		=> '</div>
											<div '.$div_args.'>
												<input type="text" id="iposttype" value="'.$post_type.'" />
												<input type="text" id="itemplate" value="'.$template.'" />
												<input type="text" id="itaxname" value="'.$tax_name.'"/>
												<input type="text" id="itaxterm" value="'.$tax_term.'" />
												<input type="text" id="ippp" value="'.$posts_per_page.'" />
												<input type="text" id="ipage" />
												<input type="text" id="ishowentries" value="'.$show_entries.'" />
												<input type="text" id="iskip" value="'.$skip.'" />
												<input type="text" id="idisplay" value="'.$display.'" />
											</div>', // closing container tag here
						'skip'			=> $skip,
						'display'		=> $display,
						'show_entries'	=> $show_entries,
						'max-pages'		=> TRUE,
					);
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );

		?><div><a id="more">More</a><span id="more_shown" style="display:none;">All entries loaded.</span></div><?php

		// reset WP_Query
		$b->swp_reset_query();

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
		wp_register_script( 'flexi_temp_ajax', get_stylesheet_directory_uri() . '/swp_template_js/asset_archive_template.js', array( 'jquery' ), NULL, TRUE );

		// get dummy page URL
        $pagez = get_page_by_path( 'archive-dummy' );

		// Localize the script with new data
		$args = array(
			'site_url' => esc_url( get_page_link( $pagez->ID ) ),
		);

		wp_localize_script( 'flexi_temp_ajax', 'flexi_temp_args', $args );

		// Enqueued script with localized data
		wp_enqueue_script( 'flexi_temp_ajax' );

	}

	// CONSTRUCT
	public function __construct() {

		if( !is_admin() ) {

			// DISPLAY LATEST ARTICLE
			add_action( 'genesis_loop', array( $this, 'swp_feature_article_function' ), 2 );

			// DISPLAY IN CONTENT AREA
			add_action( 'genesis_loop', array( $this, 'swp_custom_archive_function' ), 10 );

			// LOAD JS SCRIPTS
			add_action( 'wp_enqueue_scripts', array( $this, 'swp_load_scripts_func' ) );

		}

	}

}


/* --------------------------------------------------------------------------------------------
 * Do not remove the last line | call genesis
 * ----------------------------------------------------------------------------------------- */
genesis();