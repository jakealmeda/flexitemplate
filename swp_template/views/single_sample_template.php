<?php

if ( ! defined( "ABSPATH" ) ) {
    exit; // Exit if accessed directly
}

// Do not edit/remove the next line
global $use_this_id;

?>

<div>

	<?php $swp_field = get_post_meta( $use_this_id, "card", TRUE ); ?>
	<?php if ( $swp_field ): ?>
		<div class="item-card"><?php echo wp_get_attachment_image( $swp_field, $size = "thumbnail", $icon = false ); ?></div>
	<?php endif ?>

    <div class="item-title">
		<h6><a href="<?php echo get_the_permalink( $use_this_id ); ?>"><?php echo get_the_title( $use_this_id ); ?></a></h6>
	</div>


</div>