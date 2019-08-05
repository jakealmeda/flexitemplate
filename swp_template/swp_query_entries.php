<?php

// Do not edit the next 3 lines
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// include WP_Query function
include_once( 'swp_wp_query.php' );

class SWP_QueryEntries {

	// DISPLAY TEMPLATE
	public function swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show, $more ) {
		
		global $wp_query, $use_this_id, $jquery_counter;

		$x = new SWP_WPQueryPosts();
		$wp_query = $x->swp_query_archive_posts( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $meta_query, $orderbymeta, $orderby, $order );
		
		//global $max_page = $wp_query->max_num_pages;
        
		$h = 1; // set counter for next, previous and all displays

		// check if template is declared
		if( $template && $template != 'template' ) {
			$temp = $template;
		} else {
			$temp = $this->swp_template_filename();
		}
		
		// validate template directory
		$template_dir = 'views';
        $this->swp_check_templates( $template_dir );
        
		// The Loop
		if ( $wp_query->have_posts() ) {

			$checker = "";

			// unset arrays
			$this->swp_unset_array( $past );
			$this->swp_unset_array( $future );

			// opening container tag
			// ----------------------------------
			if( $more[ 'tag-open' ] ) {
				echo $more[ 'tag-open' ];
			}

			// loop
			while( $wp_query->have_posts() ): $wp_query->the_post(); //global $post;
				
				$use_this_id = ''; // reset variable so as not to affect the next loop
                
				// navigator (Prev, Next, Both)
				if( in_array( $show, array( 'previous', 'next', 'both' ) ) ) {

					//$out_prev = ''; $out_next = '';
					
					// catch current post and display previous post details
					if( $current_post_id == get_the_ID() ) {

						// show Previous pane if NOT the first article
						if( $h > 1 ) {

							// show pane if called
							if( $show == 'previous' || $show == 'both' ) {
								$use_this_id = $previous_id;
								echo $this->swp_get_local_file_contents( plugin_dir_path( __FILE__ ).$template_dir."/".$temp );
							}

						}

						// mark the NEXT article based on the loop ($h)
						$the_next_post = $h + 1;

					}
					
					// catch previous entry
					$previous_id = get_the_ID();

					// get next entry | can be found in loop $h + 1
					if( $h == $the_next_post ) {

						// surprisingly this pane doesn't show if the current post is the last one - hooray!

						if( $show == 'next' || $show == 'both' ) {
							$use_this_id = get_the_ID();
							echo $this->swp_get_local_file_contents( plugin_dir_path( __FILE__ ).$template_dir."/".$temp );
						}

						// no need to continue with the loop
						break;
					}
					
					// increment
					$h++;

					// add value to variable
					$checker++;

				}

				// grid
				if( is_numeric( $show ) ) {

					// set this counter to determine what entry are we
					// will be the trigger on how many AFTER entries to be displayed
					$grid_counter++;

					//echo $this->swp_grid_display( $show, $current_post_id, get_the_ID() );
					
					// set trigger to stop gathering of previous entries before current post in the loop
					if( $current_post_id == get_the_ID() ) {
						$stop_past = 1; // trigger BEFORE and AFTER entries
						$grid_counter_stop = $grid_counter; // get current counter value
						//echo 'current: '.get_the_ID().'<br />';
					}

					if( !$stop_past ) {
						// harvest entries BEFORE current post in the loop
						$p_counter++;
						$past[ $p_counter ] = get_the_ID();
						//echo count( $past ).' | <a href="'.get_the_permalink( get_the_ID() ).'">'.get_the_ID().'</a><br />';
					} else {
						if( $current_post_id != get_the_ID() ) {
							// harvest entries AFTER current post in the loop
							$f_counter++;
							$future[ $f_counter ] = get_the_ID();
							//echo count( $future ).' | <a href="'.get_the_permalink( get_the_ID() ).'">'.get_the_ID().'</a><br />';
						}
					}

					// add value to variable
					$checker++;

				}

				// get entries via custom field
				if( $show == 'meta' ) {

					// separate ID checking since if $show is equal to meta, trigger the $checker
					if( $current_post_id != get_the_ID() ) {
						
						$use_this_id = get_the_ID();
						echo $this->swp_get_local_file_contents( plugin_dir_path( __FILE__ ).$template_dir."/".$temp );

					}

					// add value to variable
					$checker++;

				}
				
				// validate variable, if false, the template calling is archive
				if( ! $checker ) {

					// call template
					echo $this->swp_get_local_file_contents( plugin_dir_path( __FILE__ ).$template_dir."/".$temp );

				}
				
			endwhile;

			$use_this_id = "";

			// Grid - display gathered entries
			if( is_numeric( $show ) ) {

				// validate current post location in the loop
				if( $grid_counter_stop == 1 ) {
					$shower = $show;
				} else {
					$shower = $show - 1;
				}

				// get remaining AFTER current post entries to determine the number of entries BEFORE current post
				for( $q=1; $q<=$shower; $q++ ) {
					if( $future[ $q ] ) {
						$filter_future[] = $future[ $q ];
					} else {
						break;
					}
				}

				// set loop limit
				$past_limit = ( ( count($past) - ( $show - count( $filter_future ) ) ) + 1 );
				
				// get the BEFORE
				for( $h=count($past); $h>=$past_limit; $h-- ) {
					$filter_past[] = $past[ $h ];
				}

				// handle the display
				if( is_array( $filter_past ) && is_array( $filter_future ) ) {

					// current post is in the middle of the loop
					foreach( array_merge( array_reverse( $filter_past ), $filter_future ) as $value ) {
						$use_this_id = $value;
						echo $this->swp_get_local_file_contents( plugin_dir_path( __FILE__ ).$template_dir."/".$temp );
					}

				} elseif( !is_array( $filter_past ) && is_array( $filter_future ) ) {

					// current post is the first entry of the loop
					foreach( $filter_future as $value ) {
						$use_this_id = $value;
						echo $this->swp_get_local_file_contents( plugin_dir_path( __FILE__ ).$template_dir."/".$temp );
					}

				} else {

					// current post is the last entry of the loop
					foreach( $filter_past as $value ) {
						$use_this_id = $value;
						echo $this->swp_get_local_file_contents( plugin_dir_path( __FILE__ ).$template_dir."/".$temp );
					}

				}

			}

			// closing container tag
			// ----------------------------------
			if( $more[ 'tag-close' ] ) {
				echo $more[ 'tag-close' ];
			}
			/* ----------------------------------
			 * | the goal for the tag-open and tag-close
			 * | is so we can segregate the content from
			 * | the pagination
			 * ------------------------------- */

			/* PAGINATION
			 * ---------------------------------------------------------------------------- */
			if( $pagination_temp == 1 ) {
				// With previous and next pages
				previous_posts_link(); next_posts_link();
			}

			if( $pagination_temp == 2 ) {
				// Without previous and next pages
				the_posts_pagination( array( 'mid_size'  => 2 ) );
			}

			if( $pagination_temp == 3 ) {
				// Pagination with Alternative Prev/Next Text
				echo get_the_posts_pagination( array(
				    'mid_size' => 2,
				    'prev_text' => __( '<<', 'textdomain' ),
				    'next_text' => __( '>>', 'textdomain' ),
				) );
			}

			/*if( $pagination_temp == 4 ) {
				echo '<h2>'.$paged.'</h2>';
	            // Class Reference/WP Query
	            $pag_args1 = array(
	                'format'  => '?paged=%#%',
	                'current' => $paged,
	                'total'   => $wp_query->max_num_pages,
	                'add_args' => array( 'paged2' => $paged2 )
	            );
	            echo paginate_links( $pag_args1 );
			}*/

			if( $pagination_temp == 'ajax' ) {

				// hide this navigation if pages is equal to 1
				if( $wp_query->max_num_pages > 1 ) {

					echo '<div style="width:100%;" align="right">
							<input type="text" id="max_posts_'.$more[ 'nav-count' ].'" value="'.$wp_query->max_num_pages.'" style="display:none;" />
							Navigator #: '.$more[ 'nav-count' ].' |
							<span id="prev_0_'.$more[ 'nav-count' ].'">Back</span>
							<a id="prev_'.$more[ 'nav-count' ].'" style="display:none;">Back</a>
							|
							<span id="next_0_'.$more[ 'nav-count' ].'" style="display:none;">Next</span>
							<a id="next_'.$more[ 'nav-count' ].'">Next</a>
						</div>';

				}

			}
			/* PAGINATION END
			 * ---------------------------------------------------------------------------- */


			/* Restore original Post Data */
			$this->swp_reset_query();

		}

	}

	// GET CONTENTS OF THE TEMPLATE FILE
	public function swp_get_local_file_contents( $file_path ) {
		
	    ob_start();
	    include $file_path;
	    return ob_get_clean();

	}

	// SIMPLE VALIDATION OF PARAMETER CONTENTS
	public function swp_validate_param( $parameter, $value ) {

		if( $parameter == $value ) {
			return NULL;
		} else {
			return $parameter;
		}

	}
	
	// VALIDATE TEMPLATE FOLDER AND FILE, AND CREATE IF MISSING
	private function swp_check_templates( $template_dir ) {

	    // /home/user/var/www/wordpress/wp-content/plugins/my-plugin/
	    $this_dir = plugin_dir_path( __FILE__ ).$template_dir;
	    
	    if( ! is_dir( $this_dir ) ) {
	        mkdir( $this_dir );
	    }
	    
	    if( ! file_exists ( $this_dir.'/'.$this->swp_template_filename() ) ) {
	        
	        $fp = fopen( $this_dir.'/'.$this->swp_template_filename(), 'w' );
	        
            fwrite( $fp, $this->swp_sample_template() );
            
            fclose( $fp );
            
	    }

	    return TRUE;
	    
	}
	
	// SAMPLE TEMPLATE CONTENTS
	private function swp_sample_template() {
	    
        return '<?php
        
        if ( ! defined( "ABSPATH" ) ) {
            exit; // Exit if accessed directly
        }
        
        ?>
        
        <section>
        
        	<div class="item-title">
        		<h4><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
        	</div>
        
        
        	<?php $swp_field = get_post_meta( get_the_ID(), "card", TRUE ); ?>
        	<?php if ( $swp_field ): ?>
        		<div class="item-pic"><?php echo wp_get_attachment_image( $swp_field, $size = "thumbnail", $icon = false ); ?></div>
        	<?php endif ?>
        
        </section>';
	    
	}

	// Sample Template filename
	public function swp_template_filename () {
		return 'sample_template.php';
	}

	// RESET QUERIES
	public function swp_reset_query() {
		wp_reset_query();
		wp_reset_postdata();
	}

	// Unset Array
	private function swp_unset_array( $array ) {
		if( is_array( $array ) ) {
			unset( $array );
		}
	}

}