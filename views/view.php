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
					<?php
					// Icon for taxonomy choice in sorting choices.
					$sort_icon = ( isset( $atts['taxonomy_icon'] ) && $atts['taxonomy_icon'] ) ?
								 '<i class = "' . esc_attr( $atts['taxonomy_icon']['icon-class'] ) . ' cwpgt-icon"></i>' :
								 '';
					echo $sort_icon;
					?>

					<!-- List of terms from 'products' taxonomy. -->
					<ul class = "terms">
						<?php
						// Each term name from 'products' taxonomy outputing in loop.
						foreach ( $terms as $key => $term ) {
							// If it's the first element - add active class for brand color.
							if ( $key === 0 ) {
								echo '<li class = "term cwpgt_active" data-term = "' . esc_attr( $term->slug ) . '">';
								// First term slug for first products sort after page load (used in new WP_Query in products sorting).
								$first_term_slug = $term->slug;
							}	else {	// Other elements without active class.
								echo '<li class = "term" data-term = "' . esc_attr( $term->slug ) . '">';
							}

							// Term name.
							printf( esc_html__( '%s', 'mebel-laim' ), $term->name );
							echo '</li>';
						}
						?>
					</ul>
				</div>

				<div class = "sorting-wrapper">
					<?php
					// Icon for taxonomy choice in sorting choices.
					$sort_icon = ( isset( $atts['sorting_icon'] ) && $atts['sorting_icon'] ) ?
								 '<i class = "' . esc_attr( $atts['sorting_icon']['icon-class'] ) . ' cwpgt-icon"></i>' :
								 '';
					echo $sort_icon;
					?>

					<!-- Sorting products by. -->
					<ul class = "sorting">
						<!-- Add active class for brand color to the first element. -->
						<li class = "sort cwpgt_active" data-sort = "new">
							<?php esc_html_e( 'Новые', 'mebel-laim' ) ?>
						</li>
						<li class = "sort" data-sort = "old">
							<?php esc_html_e( 'Старые', 'mebel-laim' ) ?>
						</li>
						<li class = "sort" data-sort = "expensive">
							<?php esc_html_e( 'Дорогие', 'mebel-laim' ) ?>
						</li>
						<li class = "sort" data-sort = "cheap">
							<?php esc_html_e( 'Дешевые', 'mebel-laim' ) ?>
						</li>
						<li class = "sort" data-sort = "az">
							<?php esc_html_e( 'По алфавиту (А-Я)', 'mebel-laim' ) ?>
						</li>
						<li class = "sort" data-sort = "za">
							<?php esc_html_e( 'По алфавиту (Я-А)', 'mebel-laim' ) ?>
						</li>
					</ul>
				</div>

				<div class = "price-sorting-wrapper">
					<?php
					// Icon for taxonomy choice in sorting choices.
					$sort_icon = ( isset( $atts['price_icon'] ) && $atts['price_icon'] ) ?
								 '<i class = "' . esc_attr( $atts['price_icon']['icon-class'] ) . ' cwpgt-icon"></i>' :
								 '';
					echo $sort_icon;
					?>

					<?php
					$min_and_max_price_query = new WP_Query(
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

					if ( $min_and_max_price_query->have_posts() ) {
						$iter = 0;

						while( $min_and_max_price_query->have_posts() ) : $min_and_max_price_query->the_post();
							$id = get_the_ID();

							if ( $iter === 0 ) {	// If it's first iteration.
								$min_price = $max_price = fw_get_db_post_option( $id, 'new_price' );	// Min & Max prices = first in array product price.
								$iter++;
								continue;	// Go to next iteration.
							}

							if ( fw_get_db_post_option( $id, 'new_price' ) > $max_price ) {
								$max_price = fw_get_db_post_option( $id, 'new_price' );
							}

							if ( fw_get_db_post_option( $id, 'new_price' ) < $min_price ) {
								$min_price = fw_get_db_post_option( $id, 'new_price' );
							}

							$iter++;
						endwhile;
					}
					wp_reset_query();
					?>

					<!-- Input fields for min & max price. -->
					<div class = "price-sorting">
						<input type = "text" class = "price-sorting__input price-sorting__input_min" value = "<?php echo esc_attr( $min_price ) ?>" data-min = "<?php echo esc_attr( $min_price ) ?>" />
						<input type = "text" class = "price-sorting__input price-sorting__input_max" value = "<?php echo esc_attr( $max_price ) ?>" data-max = "<?php echo esc_attr( $max_price ) ?>" />
						<span class = "cwpgt-apply-filters" title = "<?php esc_attr_e( 'Применить фильтры', 'mebel-laim' ) ?>">
							<?php
							// Icon for taxonomy choice in sorting choices.
							$sort_icon = ( isset( $atts['filter_icon'] ) && $atts['filter_icon'] ) ?
										 '<i class = "' . esc_attr( $atts['filter_icon']['icon-class'] ) . ' cwpgt-icon"></i>' :
										 '';
							echo $sort_icon . esc_html__( 'Применить фильтры', 'mebel-laim' );
							?>
						</span>
					</div>
				</div>
			</div><!-- .fw-col-xs-12 -->
		</div><!-- .fw-row -->

		<div class = "fw-row">
			<div class = "term-products-wrapper clear">
				<?php
				$products_per_page = ( isset( $atts['products_per_page'] ) && $atts['products_per_page'] ) ? $atts['products_per_page'] : 1;
				$new_query = new WP_Query(
					[
						'posts_per_page'	=> $products_per_page,	// Limit of displayed products.
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

				// If our new query has posts (products).
				if ( $new_query->have_posts() ) {
					while( $new_query->have_posts() ) : $new_query->the_post();
						$id = get_the_ID();
						?>
						<div class = "fw-col-md-3 fw-col-sm-4">
							<div class = "cwpgt-product">
								<div class = "cwpgt-product-image" style = "background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( $id, 'medium' ) ) ?>)">
									<!-- Overlays are showing when PLUS icon is clicked. -->
									<div class = "cwpgt-button-overlay-before_brand"></div>
									<div class = "cwpgt-button-overlay-before"></div>

									<!-- Buttons are showing when PLUS icon is clicked. -->
									<div class = "cwpgt-button-overlay animated">
										<a class = "button cwpgt-more-info-button animated" href = "#" data-id = "<?php echo esc_attr( $id ) ?>">
											<?php esc_html_e( 'Больше информации', 'mebel-laim' ) ?>
										</a>
										<a class = "button animated" href = "#" style = "animation-delay: 150ms">
											<?php esc_html_e( 'Быстрый заказ', 'mebel-laim' ) ?>
										</a>
										<a class = "button animated" href = "#" style = "animation-delay: 300ms">
											<?php esc_html_e( 'Добавить в корзину', 'mebel-laim' ) ?>
										</a>
										<a class = "button animated" href = "<?php esc_url( the_permalink() ) ?>" style = "animation-delay: 450ms">
											<?php esc_html_e( 'Перейти к товару', 'mebel-laim' ) ?>
										</a>
									</div>

									<!-- PLUS icon. -->
									<a href = "#" class = "cwpgt-product-actions" title = "<?php esc_attr_e( 'Действия', 'mebel-laim' ) ?>" data-clicked = "0">
										<!-- Horizontal line. -->
						 				<span class = "cwpgt-product-actions__line"></span>
						 				<!-- Vertical line. -->
						 				<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
						 			</a>
								</div><!-- .cwpgt-product-image -->

								<div class = "cwpgt-product-term">
									<?php
						 			// Getting all terms of current product in taxonomy "products".
						 			$terms = wp_get_post_terms( $id, 'products' );

						 			// Searching if one of terms has no child terms - this is the lowest term, we need it.
						 			foreach ( $terms as $term ) {
						 				if ( count( get_term_children( $term->term_id, 'products' ) ) === 0 ) {
						 					?>
						 					<a class = "cwpgt-product-term__link" href = "<?php echo esc_url( get_term_link( $term->term_id, 'products' ) ) ?>">
						 						<?php printf( esc_html__('%s', 'mebel-laim'), $term->name ) ?>
						 					</a>
						 					<?php
						 					break;
						 				}
						 			}
						 			?>
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
				?>
			</div><!-- .term-products-wrapper.clear -->

			<!--
				Products pagination.
				@attr data-per-page - products per page count from options
			-->
			<div class = "cwpgt-pagination" data-per-page = "<?php echo esc_attr( $products_per_page ) ?>">
				<?php if ( $new_query->max_num_pages > 1 ) : ?>
					<a href = "#" class = "page-numbers cwpgt-pagination__previous">
						<span class = "cwpgt-product-actions__line"></span>
						<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
					</a>

				    <?php
			        echo paginate_links(
			        	array(
				            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				            'total'        => $new_query->max_num_pages,
				            'current'      => max( 1, get_query_var( 'paged' ) ),
				            'format'       => '?paged=%#%',
				            'show_all'     => false,
				            'type'         => 'plain',
				            'end_size'     => 2,
				            'mid_size'     => 1,
				            'prev_next'    => false,
				            'add_args'     => false,
				            'add_fragment' => ''
			        	)
			        );
				    ?>

				    <a href = "#" class = "page-numbers cwpgt-pagination__next">
						<span class = "cwpgt-product-actions__line"></span>
						<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
					</a>
				<?php endif ?>
			</div>

			<?php wp_reset_query();	// Clearing query ($new_query) for correct work of other loops. ?>
		</div><!-- .fw-row -->
	</div><!-- .fw-container -->

	<!-- Hidden block to show more info about product, when .cwp-slide-more-info-button is clicked. -->
	<div class = "cwpgt-more-info-wrapper animated">
		<!-- Close wrapper. -->
		<a href = "#" class = "close-popup" title = "<?php esc_attr_e( 'Действия', 'mebel-laim' ) ?>" data-clicked = "0">
			<!-- Horizontal line. -->
			<span class = "cwpgt-product-actions__line"></span>
			<!-- Vertical line. -->
			<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
		</a>

		<div class = "cwpgt-more-info animated">
			<h2 class = "cwpgt-more-info__title cwpgt-vertical-line-for-header"></h2>

			<div class = "cwpgt-more-info-prices">
				<?php
				// Icon for every specification field.
				$currency_icon = ( isset( $atts['currency_icon'] ) && $atts['currency_icon'] ) ?
							 '<i class = "' . esc_attr( $atts['currency_icon']['icon-class'] ) . '"></i>' :
							 '';
				?>

				<span class = "cwpgt-more-info-prices__old">
					<span class = "cwp-more-info-prices__value"></span>
					<span class = "cwp-more-info-prices__currency">
						<?php echo $currency_icon ?>
					</span>
				</span>
				<span class = "cwpgt-more-info-prices__new">
					<span class = "cwp-more-info-prices__value"></span>
					<span class = "cwp-more-info-prices__currency">
						<?php echo $currency_icon ?>
					</span>
				</span>
			</div>

			<div class = "cwpgt-more-info-item cwpgt-more-info-colors animated"></div>

			<?php
			// Icon for every specification field.
			$specification_icon = ( isset( $atts['specification_icon'] ) && $atts['specification_icon'] ) ?
						 '<i class = "' . esc_attr( $atts['specification_icon']['icon-class'] ) . ' cwpgt-more-info__icon"></i>' :
						 '';
			?>

			<div class = "cwpgt-more-info-item cwpgt-more-info-type animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Тип:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>
			<div class = "cwpgt-more-info-item cwpgt-more-info-material animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Материал:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>
			<div class = "cwpgt-more-info-item cwpgt-more-info-width animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Длина:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>
			<div class = "cwpgt-more-info-item cwpgt-more-info-height animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Высота:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>
			<div class = "cwpgt-more-info-item cwpgt-more-info-depth animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Глубина:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>
			<div class = "cwpgt-more-info-item cwpgt-more-info-manufacture-country animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Количество в упаковке:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>
			<div class = "cwpgt-more-info-item cwpgt-more-info-brand-country animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Производитель:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>
			<div class = "cwpgt-more-info-item cwpgt-more-info-guarantee animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Страна производства:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>
			<div class = "cwpgt-more-info-item cwpgt-more-info-number-per-pack animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Гарантия:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>
			<div class = "cwpgt-more-info-item cwpgt-more-info-text animated">
				<span class = "cwpgt-product__label">
					<?php echo $specification_icon . ' ' . esc_html__( 'Дополнительная информация:', 'mebel-laim' ) ?>
				</span>
				<span class = "cwpgt-product__value"></span>
			</div>

			<div class = "cwpgt-more-info-buttons">
				<a class = "button cwpgt-more-info-buttons__button button_go-to-product" href = "#">
					<?php esc_html_e( 'На страницу товара', 'mebel-laim' ) ?>
				</a>
				<a class = "button cwpgt-more-info-buttons__button button_add-to-cart" href = "#">
					<?php esc_html_e( 'Добавить в корзину', 'mebel-laim' ) ?>
				</a>
				<a class = "button cwpgt-more-info-buttons__button button_quick-order" href = "#">
					<?php esc_html_e( 'Быстрый заказ', 'mebel-laim' ) ?>
				</a>
			</div>
		</div><!-- .cwp-more-info -->

		<div class = "cwpgt-more-info-right">
			<!-- Product image. -->
			<div class = "cwpgt-more-info-image-wrapper animated"></div>
			<!-- More product images (if exist). -->
			<div class = "cwpgt-more-info-images animated"></div>
		</div>
	</div><!-- .cwp-more-info-wrapper -->
</section>