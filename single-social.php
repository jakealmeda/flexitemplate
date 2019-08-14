<?php
/* --------------------------------------------------------------------------------------------
 * remove the underscore (_) between Template & Name (line 7) to activate PAGE ARCHIVE template
 * from Template_Name to Template Name
 * 				- OR -
 * Leave the Template_Name (with the underscore) as is and rename the name of this file
 * to something like archive-video.php for GLOBAL ARCHIVE template
 * ----------------------------------------------------------------------------------------- */
/**
 * Template_Name: Video Entry
 * Description: This template is designated for a single video entry
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
//remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop

// REMOVE GENESIS POST ENTRY-HEADER
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

// REMOVE GENESIS POST ENTRY-INNER
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_permalink', 14 );

// REMOVE GENESIS POST ENTRY-FOOTER
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );


/* --------------------------------------------------------------------------------------------
 * Main Class
 * The Class name should be unique - rename the class names in the next two lines
 * ----------------------------------------------------------------------------------------- */
$a = new SWPTemplateSample();
class SWPTemplateSample {

	// DISPLAY PODCAST ACTUAL
	public function swp_podcast_entry_actual() {

	    // IMAGE
        $swp_field = get_post_meta( get_the_ID(), "pic", TRUE );
        if ( $swp_field ) {
            ?><div class="item-pic"><a href="<?php echo get_the_permalink(); ?>"><?php echo wp_get_attachment_image( $swp_field, $size = "medium-large", $icon = false ); ?></a></div><?php
        }

	}

	// DISPLAY PODCAST INFO
	public function swp_podcast_entry_info() {

		?><section class="single-info"><?php
		echo '<div class="item-podcast">'.do_shortcode( get_post_meta( get_the_ID(), podcast_embed, TRUE ) ).'</div>';
		echo '<div class="item-title">'.do_shortcode( get_the_title() ).'</div>';
		echo '<div class="item-author">Author: '.get_the_author( get_the_ID() ).'</div>';
		echo '<div class="item-excerpt">'.do_shortcode( get_the_excerpt() ).'</div>';
		?></section><?php

	}

	// DISPLAY PODCAST GRID TEMPLATE
	/*public function swp_podcast_related_function() {

		// do not edit the next line
		$b = new SWP_QueryEntries();

		/ *
			// Taxonomy guide
			// ---------------------------------------------------------------- TAGS
			$tax_name 		= 'post_tag'; 
			$tax_term		= 'mtv'; // tag slug
			// ------------------------------------------------------------ CATEGORY
			$tax_name 		= 'category';
			$tax_term		= 'official-video'; // category slug
		* /

		// pagination
		$paged1 = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$post_type 			= 'podcast';
		$template 			= 'mediaobject-horizontal.php'; // will default to pre-coded sample_template.php if no value is declared
		$tax_name 			= '';
		$tax_term			= '';
		$posts_per_page 	= 6; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$paged				= $paged1;
		$orderbymeta		= ''; // specify custom field to be ordered by
		$orderby			= ''; // order by what field (default is date)
		$order				= ''; // ASC or DESC (default is DESC)
		$pagination_temp	= 0; // choose from 1, 2 & 3 (any other value will hide the page nav)

		// opening container tag here
		echo '<div class="feature-pretitle">RELATED ITEMS</div>';
		/ *echo '<div class="grid-feature grid-2col feature-related">';
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show );
		echo '</div>';* /
        $more = array(
						'tag-open'		=> '<div class="grid-feature grid-2col feature-related">', // opening container tag here
						'tag-close'		=> '</div>', // closing container tag here
					);
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );

		// closing container tag here

	}*/

	// DISPLAY PODCAST NEXT ITEM
	public function swp_podcast_next() {
		//echo '<div class="spacein space-lrg-bottom bgcolor-red color-white space-bottom"><div class="fontsize-xsml" style="line-height:1;">RESERVED FOR</div><div class="fontsize-med" style="line-height:1;">NEXT BUTTON</div><div class="fontsize-xxxsml">The next button is the next post item relative to the current one being displayed.</div></div>';
        
        // do not edit the next line
		$b = new SWP_QueryEntries();
		
		$post_type 			= 'social';
		$template 			= 'mediaobject-next.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$current_post_id 	= get_the_ID();
		
		// WHAT TO SHOW
		$show = "next";
		
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );
		// validate $out if has contents and hide container if empty
		/*if( $out ) {
    		echo $out;
		}*/

		// reset WP_Query
		$b->swp_reset_query();
	}
	
	/*public function swp_display_all_avail_fields() {
	    
	    // overview
	    
	    // IMAGE
        $swp_field = get_post_meta( get_the_ID(), "icon", TRUE );
        if ( $swp_field ) {
            ?><div class="item-card1"><a href="<?php echo get_the_permalink(); ?>"><?php echo wp_get_attachment_image( $swp_field, $size = "thumbnail", $icon = false ); ?></a></div><?php
        }
        
        // URL
        $swp_field = get_post_meta( get_the_ID(), "cta" );
        if ( $swp_field ) {
            ?><div class="item-card2"><?php echo $swp_field[0]; ?></div><?php
        }
        
        // ALT TITLE
        $swp_field = get_post_meta( get_the_ID(), "alt_title", TRUE );
        if ( $swp_field ) {
            ?><div class="item-card3"><?php echo $swp_field; ?></div><?php
        }
	    
	}*/

	// GRID
	public function swp_podcast_related_function_2() {
        
		// do not edit the next line
		$b = new SWP_QueryEntries();
        
		$post_type 			= 'social';
		$template 			= 'mediaobject-horizontal.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		//$paged				= $paged1;
		//$pagination_temp	= ''; // choose from 1, 2 & 3 (any other value will hide the page nav)
		//$pagination_count	= 1;
        
		// WHAT TO SHOW
		$show = "4";
		$current_post_id 	= get_the_ID();
        
    	echo '<div class="feature-pretitle">MORE SOCIAL</div>';
        $more = array(
						'tag-open'		=> '<div class="grid-feature grid-2col feature-related">', // opening container tag here
						'tag-close'		=> '</div>', // closing container tag here
					);
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );

		// reset WP_Query
		$b->swp_reset_query();

	}
	
	// GRID - TERM SPECIFIC
	public function swp_podcast_related_function_termspec() {
        
		// do not edit the next line
		$b = new SWP_QueryEntries();
        
		$post_type 			= 'social';
		$template 			= 'mediaobject-horizontal.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
        $tax_name 		    = 'social_type';
		$tax_term		    = get_the_terms( get_the_ID(), $tax_name )[0]->name; // category slug
        
		// WHAT TO SHOW
		$show = "2";
		$current_post_id 	= get_the_ID();
        
    	echo '<div class="feature-pretitle">MORE '.$tax_term.'</div>';
        $more = array(
						'tag-open'		=> '<div class="grid-feature grid-2col feature-related">', // opening container tag here
						'tag-close'		=> '</div>', // closing container tag here
					);
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );

		// reset WP_Query
		$b->swp_reset_query();

	}

	// ORDER BY META VALUE
	public function swp_order_by_metavalue() {
        
		// do not edit the next line
		$b = new SWP_QueryEntries();
        
		$post_type 			= 'social';
		$template 			= 'mediaobject-horizontal.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$show 				= "meta"; // WHAT TO SHOW
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
    		$more = array(
						'tag-open'		=> '<div class="grid-feature grid-2col feature-related">', // opening container tag here
						'tag-close'		=> '</div>', // closing container tag here
					);
    		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );
    		
		}

		// reset WP_Query
		$b->swp_reset_query();

	}

	// SHOW RELATIONSHIPS
	public function swp_show_relationships() {
        
		// do not edit the next line
		$b = new SWP_QueryEntries();
        
		$template 			= 'mediaobject-related.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= -1; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$current_post_id 	= get_the_ID();
		$tax_name 			= 'related_item';

        $terms = get_the_terms( $current_post_id, $tax_name );
        foreach ($terms as $term) {

        	$tax_term = $term->slug;

			$args = array( 'public'   => true, );
	        foreach ( get_post_types( $args, 'names' ) as $post_type ) {

				//echo $post_type.'<br />';

				// hide posts for current post type
				/* ************************************************************
				 * * you might want to think about including the current post
				 * * type but exclude the current post from being displayed
				 * * there might be an entry within the post type that is
				 * * related to this post 
				 * ********************************************************* */
				if( get_post_type( $current_post_id ) != $post_type ) {

					echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );
					
					// reset WP_Query
					$b->swp_reset_query();
					
				}

			}
			
        }

		// reset WP_Query
		$b->swp_reset_query();

	}

	// CONSTRUCT
	public function __construct() {

		if( !is_admin() ) {

			// DISPLAY IN CONTENT AREA
			add_action( 'genesis_entry_content', array( $this, 'swp_podcast_entry_actual' ) );
			add_action( 'genesis_entry_content', array( $this, 'swp_podcast_entry_info' ) );
			add_action( 'genesis_entry_content', 'genesis_do_post_content' );
			//add_action( 'genesis_entry_content', array( $this, 'swp_podcast_related_function' ) );
			add_action( 'genesis_entry_content', array( $this, 'swp_podcast_related_function_termspec' ) );
			add_action( 'genesis_entry_content', array( $this, 'swp_podcast_related_function_2' ) );
			//add_action( 'genesis_entry_content', array( $this, 'swp_display_all_avail_fields' ) );
			
			//add_action( 'genesis_entry_content', array( $this, 'swp_order_by_metavalue' ) );

			// DISPLAY ABOVE SIDEBAR AREA
			add_action( 'genesis_before_sidebar_widget_area', array( $this, 'swp_podcast_next' ) );
			add_action( 'genesis_before_sidebar_widget_area', array( $this, 'swp_show_relationships' ) );

		}

	}

}


/* --------------------------------------------------------------------------------------------
 * Do not remove the last line | call genesis
 * ----------------------------------------------------------------------------------------- */
genesis();