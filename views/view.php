<?php
if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

// Slides count per one screen.
$slides_per_screen = ( isset( $atts['slides_per_screen'] ) && $atts['slides_per_screen'] ) ? $atts['slides_per_screen'] : 5;
// Timer for scrolling slider animation.
$timer = ( isset( $atts['timer'] ) && $atts['timer'] ) ? $atts['timer'] : 5;
// Seconds to miliseconds for JS.
$timer *= 1000;
?>

<!-- Slider wrapper. -->
<div class = "cwp-product-slider owl-carousel owl-theme" data-slides = "<?php esc_attr_e( $slides_per_screen ) ?>" data-timer = "<?php esc_attr_e( $timer ) ?>">
	<?php
	// If "Auto fill" slider content type is selected.
	if ( isset( $atts['is_auto'] ) && ( $atts['is_auto']['fill'] === 'auto_fill' ) ) {
		$loop = new WP_Query(	// Variable for new query.
			array(
				'post_type'			=> 'products',	// Custom post type.
				'posts_per_page'	=> 30	// Max slides count.
			)
		);

		while ( $loop->have_posts() ) : $loop->the_post();
			$id = get_the_ID();	// Current product ID.
			?>
			<div class = "cwp-slide">
				<div class = "cwp-slide-image" style = "background-image: url(<?php echo get_the_post_thumbnail_url( $id, 'medium' ) ?>)">
					<!-- Overlays are showing when PLUS icon is clicked. -->
					<div class = "button-slide-overlay-before_brand"></div>
					<div class = "button-slide-overlay-before"></div>

					<!-- Buttons are showing when PLUS icon is clicked. -->
					<div class = "button-slide-overlay animated">
						<a class = "button cwp-slide-more-info-button animated" href = "#" data-id = "<?php esc_attr_e( $id ) ?>"><?php _e( 'Больше информации', 'mebel-laim' ) ?></a>
						<a class = "button animated" href = "#" style = "animation-delay: 150ms"><?php _e( 'Быстрый заказ', 'mebel-laim' ) ?></a>
						<a class = "button animated" href = "#" style = "animation-delay: 300ms"><?php _e( 'Добавить в корзину', 'mebel-laim' ) ?></a>
						<a class = "button animated" href = "<?php the_permalink() ?>" style = "animation-delay: 450ms"><?php _e( 'Перейти к товару', 'mebel-laim' ) ?></a>
					</div>

					<!-- PLUS icon. -->
					<a href = "#" class = "product-actions" title = "<?php _e( 'Действия', 'mebel-laim' ) ?>" data-clicked = "0">
						<!-- Horizontal line. -->
		 				<span class = "product-actions__line"></span>
		 				<!-- Vertical line. -->
		 				<span class = "product-actions__line product-actions__line_vertical"></span>
		 			</a>
				</div><!-- .cwp-slide-image -->

				<div class = "cwp-slide-term">
		 			<?php
		 			// Getting all terms of current product in taxonomy "products".
		 			$terms = wp_get_post_terms( $id, 'products' );

		 			// Searching if one of terms has no child terms - this is the lowest term, we need it.
		 			foreach ( $terms as $term ) {
		 				if ( count( get_term_children( $term->term_id, 'products' ) ) === 0 ) {
		 					?>
		 					<a class = "cwp-slide-term__link" href = "<?php echo get_term_link( $term->term_id, 'products' ) ?>"><?php esc_html_e( $term->name, 'mebel-laim' ) ?></a>
		 					<?php
		 					break;
		 				}
		 			}
		 			?>
		 		</div><!-- .cwp-slide-term -->

				<div class = "cwp-slide-info">
					<div class = "cwp-slide-title">
			 			<h3 class = "cwp-slide-text__header">
			 				<?php the_title() ?>
			 			</h3>
			 		</div>

			 		<div class = "cwp-slide-price">
			 			<?php
		 				/**
		 				 * If product new price is not empty.
		 				 * 
		 				 * @ Product -> Prices -> New Price.
		 				 */
			 			if ( fw_get_db_post_option( $id, 'new_price' ) ) {
			 				?>
			 				<span class = "cwp-slide-price__new">
			 					<?php echo number_format( fw_get_db_post_option( $id, 'new_price' ), 0, '.', ' ' ) ?>
			 					<!--
			 					RUBLE icon for currency (from Font Awesome Icons).
			 					@link https://fontawesome.com/icons
			 					-->
			 					<span class = "cwp-slide-price__currency"><i class = "fas fa-ruble-sign"></i></span>
			 				</span>
			 				<?php
			 			}
			 			?>
			 		</div><!-- .cwp-slide-price -->
				</div><!-- .cwp-slide-info -->
			</div><!-- .cwp-slide -->
			<?php
		endwhile;
		wp_reset_query();	// Clearing query for correct work of other loops.
	}	else {	// If "Manual fill" slider content type is selected.
		// 
	}
	?>
</div><!-- .cwp-product-slider -->

<!-- Hidden block to show more info about product, when .cwp-slide-more-info-button is clicked. -->
<div class = "cwp-more-info-wrapper">
	<!-- Close wrapper. -->
	<a href = "#" class = "close-popup" title = "<?php _e( 'Действия', 'mebel-laim' ) ?>" data-clicked = "0">
		<!-- Horizontal line. -->
		<span class = "close-popup__line"></span>
		<!-- Vertical line. -->
		<span class = "close-popup__line close-popup__line_vertical"></span>
	</a>

	<div class = "cwp-more-info">
		<div class = "cwp-more-info-prices">
			<span class = "cwp-more-info-prices__old"></span>
			<span class = "cwp-more-info-prices__new"></span>
		</div>

		<div class = "cwp-more-info-colors"></div>
		<div class = "cwp-more-info-type"></div>
		<div class = "cwp-more-info-material"></div>
		<div class = "cwp-more-info-width"></div>
		<div class = "cwp-more-info-height"></div>
		<div class = "cwp-more-info-depth"></div>
		<div class = "cwp-more-info-text"></div>
		<div class = "cwp-more-info-number-per-pack"></div>
		<div class = "cwp-more-info-manufacture-country"></div>
		<div class = "cwp-more-info-brand-country"></div>
		<div class = "cwp-more-info-guarantee"></div>
	</div><!-- .cwp-more-info -->

	<!-- Product image. -->
	<div class = "cwp-more-info-image-wrapper">
		<!-- Product main image. -->
		<img class = "cwp-more-info__image" src = "#" alt = "" />
		<!-- More product images (if exist). -->
		<div class = "cwp-more-info-images"></div>
	</div>
</div><!-- .cwp-more-info-wrapper -->