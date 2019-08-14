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

	// sample template function
	public function swp_custom_archive_function() {
/*
		// required global variables
        global $post, $wp_query;

		// initialize query class
		$b = new SWP_QueryEntries();

		$post_type 			= 'social';
		$template 			= 'mediaobject-social.php'; // will default to pre-coded sample_template.php if no value is declared
		$posts_per_page 	= 2; // will default to "Blog pages show at most" if no value is declared | -1 to show all
		$pagination_temp	= 4;

		//$paged 				= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$paged 				= isset( $_GET['paged'] ) ? (int) $_GET['paged'] : 1;

		$more = array(
						'tag-open'		=> '<div class="grid-third gap-lrg">', // opening container tag here
						'tag-close'		=> '</div>', // closing container tag here
					);
		echo $b->swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more );

		// reset WP_Query
		$b->swp_reset_query();
*/
// ######################################################################################################################
/*
		global $use_this_id;

		$paged1 = isset( $_GET['paged1'] ) ? (int) $_GET['paged1'] : 1;

        // Custom Loop with Pagination 1
        // Class Reference/WP Query
        $args1 = array(
        	'post_type' 		=> 'social',
        	'post_status'    	=> 'publish',
            'paged'          	=> $paged1,
            'posts_per_page' 	=> 6,
//            'offset'			=> 1,
        );
        $query1 = new WP_Query( $args1 );

        ?><div class="grid-third gap-lrg"><?php

        while ( $query1->have_posts() ) : $query1->the_post();

        	$use_this_id = get_the_ID();
        	?><div><?php
            echo '<div>'.$use_this_id.' | '.get_the_title().'</div>';

			echo '<div class="fontsize-xxsml bgcolor-black color-white spacein-tiny">'.get_the_terms( $use_this_id, 'social_type' )[0]->name.'</div>';
		    // attachment (featured image)
		    $swp_field = get_the_post_thumbnail( $use_this_id, 'card-ratio169' );
		    if ( $swp_field ) {
		        ?><div class="item-pic"><a href="<?php echo get_the_permalink( $use_this_id ); ?>"><?php echo $swp_field; ?></a></div><?php
		    }
//            echo get_stylesheet_directory() . '/swp_template/views/mediaobject-social.php';
//            $this->swp_get_local_file_contents( get_stylesheet_directory() . '/swp_template/views/mediaobject-social.php' );
		    ?></div><?php
        endwhile;

        ?></div><?php

        // Class Reference/WP Query
        $pag_args1 = array(
            'format'  => '?paged1=%#%',
            'current' => $paged1,
            'total'   => $query1->max_num_pages,
//            'add_args' => array( 'paged2' => $paged2, 'paged3' => $paged3 )
        );
        echo paginate_links( $pag_args1 );

		wp_reset_query();
		wp_reset_postdata();
*/
// ######################################################################################################################
		$number_of_posts_per_page = 4;
	    $initial_offset = 1;
	    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	    // Use paged if this is not on the front page 

	    $number_of_posts_past = $number_of_posts_per_page * ($paged - 1);
	    $off = $initial_offset + (($paged > 1) ? $number_of_posts_past : 0);

		// WP_Query arguments
	    $args = array(
	        'post_type' => 'social',
	        'post_status' => array('publish'),
	        'posts_per_page' => $number_of_posts_per_page,
	        'paged' => $paged,
	        'orderby' => 'date',
	        'offset' => $off
	    );

	    // The Query
	    $query = new WP_Query( $args );

	    // The Loop
	    if ( $query->have_posts() ) {

            $counter = 0;

            ?><div class="grid-third gap-lrg"><?php //start the row
            
            while ( $query->have_posts() ) { $query->the_post();

                $counter++;

	        	$use_this_id = get_the_ID();
	        	?><div><?php
	            echo '<div>'.$use_this_id.' | '.get_the_title().'</div>';

				echo '<div class="fontsize-xxsml bgcolor-black color-white spacein-tiny">'.get_the_terms( $use_this_id, 'social_type' )[0]->name.'</div>';
			    // attachment (featured image)
			    $swp_field = get_the_post_thumbnail( $use_this_id, 'card-ratio169' );
			    if ( $swp_field ) {
			        ?><div class="item-pic"><a href="<?php echo get_the_permalink( $use_this_id ); ?>"><?php echo $swp_field; ?></a></div><?php
			    }
	//            echo get_stylesheet_directory() . '/swp_template/views/mediaobject-social.php';
	//            $this->swp_get_local_file_contents( get_stylesheet_directory() . '/swp_template/views/mediaobject-social.php' );
			    ?></div><?php

	        } // End of the loop
			
			echo '</div>'; //close the row
			
			//display pagination
			echo '<div class="page-navigation">';
				//the_post_navigation();
				the_posts_pagination( array( 'mid_size'  => 2 ) );
		    echo '</div>';

	    } else {
	            // no posts found
	    }

	    // Restore original Post Data
	    wp_reset_postdata();
	}


	// GET CONTENTS OF THE TEMPLATE FILE
	/*public function swp_get_local_file_contents( $file_path ) {
		
	    ob_start();
	    include $file_path;
	    return ob_get_clean();

	}*/


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