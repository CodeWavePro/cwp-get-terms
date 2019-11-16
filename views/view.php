<?php
if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

// Get terms by taxonomy slug.
$terms = get_terms(
	[
		'taxonomy'		=> 'products',	// Taxonomy slug.
		'hide_empty'	=> true 	// Do not show empty terms.
	]
);
?>

<section class = "fw-main-row section-sort">
	<div class = "fw-container">
		<div class = "fw-row">
			<div class = "fw-col-xs-12">
				<div class = "terms-wrapper">
					<!--
					Icon from Font Awesome Icons.
					@link https://fontawesome.com/icons
					-->
					<i class = "fas fa-stream cwpgt-icon"></i>

					<!-- List of terms from 'products' taxonomy. -->
					<ul class = "terms">
						<?php
						// Each term name from 'products' taxonomy outputing in loop.
						foreach ( $terms as $key => $term ) {
							// If it's the first element - add active class for brand color.
							if ( $key === 0 ) {
								echo '<li class = "term cwpgt_active">';
								// First term slug for first products sort after page load (used in new WP_Query in products sorting).
								$first_term_slug = $term->slug;
							}	else {	// Other elements without active class.
								echo '<li class = "term">';
							}

							// Term name.
							esc_html_e( $term->name );
							echo '</li>';
						}
						?>
					</ul>
				</div>

				<div class = "sorting-wrapper">
					<!--
					Icon from Font Awesome Icons.
					@link https://fontawesome.com/icons
					-->
					<i class = "fas fa-sort cwpgt-icon"></i>

					<!-- Sorting products by. -->
					<ul class = "sorting">
						<!-- Add active class for brand color to the first element. -->
						<li class = "sort cwpgt_active"><?php esc_html_e( 'Новые', 'mebel-laim' ) ?></li>
						<li class = "sort"><?php esc_html_e( 'Старые', 'mebel-laim' ) ?></li>
						<li class = "sort"><?php esc_html_e( 'Дорогие', 'mebel-laim' ) ?></li>
						<li class = "sort"><?php esc_html_e( 'Дешевые', 'mebel-laim' ) ?></li>
						<li class = "sort"><?php esc_html_e( 'По алфавиту (А-Я)', 'mebel-laim' ) ?></li>
						<li class = "sort"><?php esc_html_e( 'По алфавиту (Я-А)', 'mebel-laim' ) ?></li>
					</ul>
				</div>
			</div><!-- .fw-col-xs-12 -->
		</div><!-- .fw-row -->

		<div class = "fw-row">
			<div class = "term-products-wrapper clear">
				<?php
				$new_query = new WP_Query(
					[
						'posts_per_page'	=> -1,	// No limit for count of displayed products.
						'post_type'			=> 'products',	// Post type.
						'tax_query'			=> [
							[
								'taxonomy'	=> 'products',	// Taxonomy name.
								'field'		=> 'slug',	// Posts will be outputing by term slug.
								'terms'		=> $first_term_slug	// Term slug.
							]
						]
					]
				);

				if ( $new_query->have_posts() ) {
					while( $new_query->have_posts() ) : $new_query->the_post();
						$id = get_the_ID();
						?>
						<div class = "fw-col-md-3">
							<div class = "cwpgt-product">
								<div class = "cwpgt-product-image" style = "background-image: url(<?php echo get_the_post_thumbnail_url( $id, 'medium' ) ?>)">
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
								</div><!-- .cwpgt-product-image -->

								<div class = "cwpgt-product-term">
						 			<a class = "cwpgt-product-term__link" href = "<?php echo get_term_link( $term->term_id, 'products' ) ?>"><?php esc_html_e( $term->name, 'mebel-laim' ) ?></a>
						 		</div><!-- .cwp-slide-term -->

								<div class = "cwpgt-product-info">
									<div class = "cwpgt-product-title">
							 			<h3 class = "cwpgt-product-text__header">
							 				<?php the_title() ?>
							 			</h3>
							 		</div>

							 		<div class = "cwpgt-product-price">
							 			<?php
						 				/**
						 				 * If product new price is not empty.
						 				 * 
						 				 * @ Product -> Prices -> New Price.
						 				 */
							 			if ( fw_get_db_post_option( $id, 'new_price' ) ) {
							 				?>
							 				<span class = "cwpgt-product-price__new">
							 					<?php echo number_format( fw_get_db_post_option( $id, 'new_price' ), 0, '.', ' ' ) ?>
							 					<!--
							 					RUBLE icon for currency (from Font Awesome Icons).
							 					@link https://fontawesome.com/icons
							 					-->
							 					<span class = "cwpgt-product-price__currency"><i class = "fas fa-ruble-sign"></i></span>
							 				</span>
							 				<?php
							 			}
							 			?>
							 		</div><!-- .cwpgt-product-price -->
								</div><!-- .cwpgt-product-info -->
							</div><!-- .cwpgt-product -->
						</div><!-- .fw-col-md-3 -->
						<?php
					endwhile;
				}	else {
					esc_html_e( 'По заданным критериям поиска товаров не найдено.', 'mebel-laim' );
				}
				wp_reset_query();	// Clearing query ($new_query) for correct work of other loops.
				?>
			</div><!-- .term-products-wrapper.clear -->
		</div>
	</div>
</section>