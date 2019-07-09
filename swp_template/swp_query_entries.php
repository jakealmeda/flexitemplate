<?php

// Do not edit the next 3 lines
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// include WP_Query function
include_once( 'swp_wp_query.php' );

class SWP_QueryEntries {

	// DISPLAY TEMPLATE
	public function swp_load_entries( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $orderbymeta, $orderby, $order, $template, $pagination_temp, $pagination_count, $current_post_id, $show ) {
		
		global $wp_query, $use_this_id;

		$x = new SWP_WPQueryPosts();
		$wp_query = $x->swp_query_archive_posts( $post_type, $posts_per_page, $tax_name, $tax_term, $paged, $orderbymeta, $orderby, $order );
		
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
/*			
			?><div id="module-container"><?php
*/
			while( $wp_query->have_posts() ): $wp_query->the_post(); //global $post;
				
				// navigator (Prev, Next, Both)
				if( in_array( $show, array( 'previous', 'next', 'both' ) ) ) {
                    // $show contains texts either NEXT, PREVIOUS or BOTH
                    
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
					
					$h++; // increment
					
					$checker++; // add value to variable

				} // if( in_array( $show, array( 'previous', 'next', 'both' ) ) ) {


				// succeeding post entries
				if( ! $chcker && $show ) {
					

					$checker++; // add value to variable
				}


				// validate variable, if false, the calling template is archive
				if( ! $checker ) {
					// call template
					echo $this->swp_get_local_file_contents( plugin_dir_path( __FILE__ ).$template_dir."/".$temp );
				}
				
			endwhile;
/*
			?>
			</div>
			<input type="text" id="page_counter" value="1" />
			<?php
*/
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

			if( $pagination_temp == 4 ) {
				echo '<h2>'.$paged.'</h2>';
	            // Class Reference/WP Query
	            $pag_args1 = array(
	                'format'  => '?paged=%#%',
	                'current' => $paged,
	                'total'   => $wp_query->max_num_pages,
	                'add_args' => array( 'paged2' => $paged2 )
	            );
	            echo paginate_links( $pag_args1 );
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
	private function swp_reset_query() {
		wp_reset_query();
		wp_reset_postdata();
	}

}