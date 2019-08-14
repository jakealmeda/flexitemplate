<?php
/* --------------------------------------------------------------------------------------------
 * Do not edit the next 3 lines
 * ----------------------------------------------------------------------------------------- */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

//* Add custom body class to the head
add_filter( 'body_class', 'sp_body_class' );
function sp_body_class( $classes ) {
    
    //$classes[] = 'grid-archive grid-all';
    $classes[] = 'grid-archive';
    return $classes;
  
}

//* Replacing excerpt with summary
//add_filter('the_excerpt', 'your_function_name');
function your_function_name($excerpt) {
    // ALT_SUMMARY
    $swp_field = get_post_meta( get_the_ID(), "alt_summary", TRUE );
    if ( $swp_field ) {
        ?><div class="item-summary"><?php echo $swp_field; ?></div><?php
    }
}

// DISPLAY VIDEO HEADER
//add_action( 'genesis_before_loop', 'swp_social_heading' );
function swp_social_heading() {
    ?><div class="fontsize-xlrg fontweight-bold archive-description">Social Media</div><?php
}


remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );


// ENTRY-HEADER
    //  add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

// ENTRY-CONTENT
//      add_action( 'genesis_entry_content', 'genesis_do_post_title' );
    //  add_action( 'genesis_entry_content', 'genesis_do_post_content' );
//add_action( 'genesis_entry_content', 'genesis_post_meta' );
//      remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );


// MANIPULATE THE WP_QUERY'S ARGUMENTS
// Query offset can be found in the theme's functions.php file

add_action( 'genesis_before_content_sidebar_wrap', 'swp_feature_latest' );
function swp_feature_latest() {

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if( $paged > 1 )
        return;

    $qObj = get_queried_object();

    $args = array(
                'offset'    => 0,
                'post_type' => $qObj->name,
                'showposts' => 1,
            );

    // The Query
    $the_query = new WP_Query( $args );
     
    // The Loop
    if ( $the_query->have_posts() ) {

        // container - opening tag
        echo '<div style="width:100%">';

        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            echo 'ID: '.get_the_ID().'<br />';
            echo 'Title: '.get_the_title().'<br />';
        }

        // container - closing tag
        echo '</div>';
    }

    // Restore original Post Data
    wp_reset_postdata();
}


// MANIPULATE THE ACTUAL ENTRY
add_action( 'genesis_entry_content', 'swp_manipulation' );
function swp_manipulation() {
    global $use_this_id;
    
    $use_this_id = get_the_ID();
    
    echo 'ID: '.$use_this_id.'<br />';
    echo 'Title: '.get_the_title().'<br />';
/*    echo 'Title with link: <a href="'.get_the_permalink( $use_this_id ).'">'.get_the_title().'</a><br />';
    echo 'Social Type: '.get_the_terms( $sid, 'social_type' )[0]->name.'<br />';
    echo '<div class="fontsize-xxsml bgcolor-black color-white spacein-tiny">'.get_the_terms( $sid, 'social_type' )[0]->name.'</div>';
*/
    // attachment (featured image)
    $swp_field = get_the_post_thumbnail( $use_this_id, 'card-ratio169' );
    if ( $swp_field ) {
        ?><div class="item-pic"><a href="<?php echo get_the_permalink( $use_this_id ); ?>"><?php echo $swp_field; ?></a></div><?php
    }
/*    
    // custom field (PIC)
    $swp_field = get_post_meta( $use_this_id, "pic", TRUE );
    if ( $swp_field ) {
        ?><div class="item-pic"><?php echo wp_get_attachment_image( $swp_field, $size = "thumbnail", $icon = false ); ?></div><?php
    }*/

    /*
    $filename = 'mediaobject-social.php';
    
    ob_start();
    include get_stylesheet_directory_uri() . '/swp_template/views/'.$filename;
    return ob_get_clean();
    */
}

genesis();