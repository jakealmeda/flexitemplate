<?php

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

</section>