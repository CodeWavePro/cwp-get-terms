<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Shortcode_CWP_Get_Terms extends FW_Shortcode {
	public function _init() {
        $this->register_ajax();
    }

    /**
     * Clean incoming value from trash.
     */
    private function clean_value( $value ) {
    	$value = trim( $value );
	    $value = stripslashes( $value );
	    $value = strip_tags( $value );
	    $value = htmlspecialchars( $value );
	    return $value;
    }

    private function switch_sorting_type( $new_sort, $new_term, $products_per_page, $min_sort, $max_sort, $offset ) {
    	switch ( $new_sort ) {
			case 'new':
				$new_query = new WP_Query(
					[
						'posts_per_page'	=> $products_per_page,	// No limit for count of displayed products.
						'post_type'			=> 'products',	// Post type.
						'offset'			=> $offset,
						'tax_query'			=> [
							[
								'taxonomy'	=> 'products',	// Taxonomy name.
								'field'		=> 'slug',	// Posts will be outputing by term slug.
								'terms'		=> $new_term	// Term slug.
							]
						],
						'orderby'			=> 'date',
						'order'				=> 'DESC',
						'meta_query'		=> array(
							array(
								'key'     => 'fw_option:new_price',
								'value'   => array( $min_sort, $max_sort ),
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC'
							)
						)
					]
				);
				break;

			case 'old':
				$new_query = new WP_Query(
					[
						'posts_per_page'	=> $products_per_page,	// No limit for count of displayed products.
						'post_type'			=> 'products',	// Post type.
						'offset'			=> $offset,
						'tax_query'			=> [
							[
								'taxonomy'	=> 'products',	// Taxonomy name.
								'field'		=> 'slug',	// Posts will be outputing by term slug.
								'terms'		=> $new_term	// Term slug.
							]
						],
						'orderby'			=> 'date',
						'order'				=> 'ASC',
						'meta_query'		=> array(
							array(
								'key'     => 'fw_option:new_price',
								'value'   => array( $min_sort, $max_sort ),
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC'
							)
						)
					]
				);
				break;

			case 'expensive':
				$new_query = new WP_Query(
					array(
						'posts_per_page'	=> $products_per_page,	// No limit for count of displayed products.
						'post_type'			=> 'products',	// Post type.
						'offset'			=> $offset,
						'tax_query'			=> array(
							array(
								'taxonomy'	=> 'products',	// Taxonomy name.
								'field'		=> 'slug',	// Posts will be outputing by term slug.
								'terms'		=> $new_term	// Term slug.
							)
						),
						'meta_key'			=> 'fw_option:new_price',
						'orderby'			=> 'meta_value_num',
						'order'				=> 'DESC',
						'meta_query'		=> array(
							array(
								'key'     => 'fw_option:new_price',
								'value'   => array( $min_sort, $max_sort ),
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC'
							)
						)
					)
				);
				break;

			case 'cheap':
				$new_query = new WP_Query(
					array(
						'posts_per_page'	=> $products_per_page,	// No limit for count of displayed products.
						'post_type'			=> 'products',	// Post type.
						'offset'			=> $offset,
						'tax_query'			=> array(
							array(
								'taxonomy'	=> 'products',	// Taxonomy name.
								'field'		=> 'slug',	// Posts will be outputing by term slug.
								'terms'		=> $new_term	// Term slug.
							)
						),
						'meta_key'			=> 'fw_option:new_price',
						'orderby'			=> 'meta_value_num',
						'order'				=> 'ASC',
						'meta_query'		=> array(
							array(
								'key'     => 'fw_option:new_price',
								'value'   => array( $min_sort, $max_sort ),
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC'
							)
						)
					)
				);
				break;

			case 'az':
				$new_query = new WP_Query(
					[
						'posts_per_page'	=> $products_per_page,	// No limit for count of displayed products.
						'post_type'			=> 'products',	// Post type.
						'offset'			=> $offset,
						'tax_query'			=> [
							[
								'taxonomy'	=> 'products',	// Taxonomy name.
								'field'		=> 'slug',	// Posts will be outputing by term slug.
								'terms'		=> $new_term	// Term slug.
							]
						],
						'orderby'			=> 'title',
						'order'				=> 'ASC',
						'meta_query'		=> array(
							array(
								'key'     => 'fw_option:new_price',
								'value'   => array( $min_sort, $max_sort ),
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC'
							)
						)
					]
				);
				break;

			case 'za':
				$new_query = new WP_Query(
					[
						'posts_per_page'	=> $products_per_page,	// No limit for count of displayed products.
						'post_type'			=> 'products',	// Post type.
						'offset'			=> $offset,
						'tax_query'			=> [
							[
								'taxonomy'	=> 'products',	// Taxonomy name.
								'field'		=> 'slug',	// Posts will be outputing by term slug.
								'terms'		=> $new_term	// Term slug.
							]
						],
						'orderby'			=> 'title',
						'order'				=> 'DESC',
						'meta_query'		=> array(
							array(
								'key'     => 'fw_option:new_price',
								'value'   => array( $min_sort, $max_sort ),
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC'
							)
						)
					]
				);
				break;
			
			default:	// Default sorting will show standart sorting: from new to old products.
				$new_query = new WP_Query(
					[
						'posts_per_page'	=> $products_per_page,	// No limit for count of displayed products.
						'post_type'			=> 'products',	// Post type.
						'offset'			=> $offset,
						'tax_query'			=> [
							[
								'taxonomy'	=> 'products',	// Taxonomy name.
								'field'		=> 'slug',	// Posts will be outputing by term slug.
								'terms'		=> $new_term	// Term slug.
							]
						],
						'orderby'			=> 'date',
						'order'				=> 'DESC',
						'meta_query'		=> array(
							array(
								'key'     => 'fw_option:new_price',
								'value'   => array( $min_sort, $max_sort ),
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC'
							)
						)
					]
				);
				break;
		}

		return $new_query;
    }

    /**
     * Register Ajax functions.
     */
    private function register_ajax() {
    	// Show more product info.
        add_action( 'wp_ajax__cwpgt_show_more', array( $this, '_cwpgt_show_more' ) );
		add_action( 'wp_ajax_nopriv__cwpgt_show_more', array( $this, '_cwpgt_show_more' ) );

		// Change sorting type.
		add_action( 'wp_ajax__cwpgt_apply_filters', array( $this, '_cwpgt_apply_filters' ) );
		add_action( 'wp_ajax_nopriv__cwpgt_apply_filters', array( $this, '_cwpgt_apply_filters' ) );

		// Pagination page numbers clicks.
		add_action( 'wp_ajax__cwpgt_pagination_number_click', array( $this, '_cwpgt_pagination_number_click' ) );
		add_action( 'wp_ajax_nopriv__cwpgt_pagination_number_click', array( $this, '_cwpgt_pagination_number_click' ) );
    }

    /**
	 * Show product more info fields in Products Slider.
	 */
    public function _cwpgt_show_more() {
    	$product_id = $_POST['product_id'];	// Getting product id.

		if ( !is_numeric( $product_id ) ) {	// If product id is not numeric.
			wp_send_json_error(	// Sending error message and exiting function.
				array(
					'message'	=> __( 'Неверный формат данных. ID товара не является числом.', 'mebel-laim' )
				)
			);
		}

		/**
		 * Prepairing all existing product fields for sending.
		 *
		 * Product title.
		 */
		$product_title = get_the_title( $product_id );

		// If product has thumbnail.
		if ( has_post_thumbnail( $product_id ) ) {
			// Array for product images, CSS-animation for appearing.
			$more_product_images_array = '
				<div class = "cwpgt-more-info-image cwpgt-more-info-image_active animated fadeInUp"
					 style = "background-image: url(' . esc_url( get_the_post_thumbnail_url( $product_id, 'full' ) ) . ');
					 		  animation-delay: 100ms"
					 data-src = "' . esc_url( get_the_post_thumbnail_url( $product_id, 'full' ) ) . '">
				</div>';
			// Full size product thumbnail.
			$product_image = get_the_post_thumbnail_url( $product_id, 'full' );
		}	else {
			$product_image = '';
		}

		// More product images with CSS-animation for their appearing.
		if ( fw_get_db_post_option( $product_id, 'images' ) ) {
			foreach ( fw_get_db_post_option( $product_id, 'images' ) as $key => $image ) {
				$more_product_images_array .=  '
					<div class = "cwpgt-more-info-image animated fadeInUp"
						 style = "background-image: url(' . esc_url( $image['image']['url'] ) . ');
						 		  animation-delay: ' . ( 100 * ( $key + 2 ) ) . 'ms"
						 data-src = "' . esc_url( $image['image']['url'] ) . '">
					</div>';
			}
		}

		// If product has colors.
		if ( fw_get_db_post_option( $product_id, 'colors' ) ) {
			// Empty list for all colors of current product.
			$product_colors_array = '<ul class = "cwpgt-more-info-colors-list">';

			foreach ( fw_get_db_post_option( $product_id, 'colors' ) as $key => $color ) {
				// Colors list item tag open. Add active class if it's the first item.
				if ( $key === 0 ) {
					$product_colors_array .= '<li class = "cwpgt-more-info-colors-item cwpgt-more-info-colors-item_active">';
				}	else {
					$product_colors_array .= '<li class = "cwpgt-more-info-colors-item">';
				}

				// If color has name.
				if ( isset( $color['color_name'] ) ) {
					$product_colors_array .= '<span class = "cwpgt-more-info-colors-item__title">' . sprintf( esc_html__( '%s', 'mebel-laim' ), $color['color_name'] ) . '</span>';
				}

				// If color type is chosen.
				if ( isset( $color['color_type'] ) ) {
					switch ( $color['color_type']['color_type_select'] ) {
						case 'color_pallete':	// If color is chosen as pallete.
							$product_colors_array .= '<span class = "cwpgt-more-info-colors-item__color" style = "background-color: ' . esc_attr( $color['color_type']['color_pallete']['if_color_pallete'] ) . '"></span>';
							break;

						case 'image_upload':	// If color is chosen as image.
							$product_colors_array .= '<span class = "cwpgt-more-info-colors-item__color" style = "background-image: url(' . esc_url( $color['color_type']['image_upload']['if_image_upload']['url'] ) . ')"></span>';
							break;
						
						default:
							$product_colors_array .= esc_html__( 'No colors chosen.', 'mebel-laim' );
							break;
					}
				}
				$product_colors_array .= '</li>';	// Close HTML list item tag.
			}
			$product_colors_array .= '</ul>';	// Close HTML list tag.
		}

		// Old price.
		if ( fw_get_db_post_option( $product_id, 'old_price' ) ) {
			/**
			 * RUBLE icon for currency (from Font Awesome Icons).
			 * @link https://fontawesome.com/icons
			 */
			$product_price_old = number_format( fw_get_db_post_option( $product_id, 'old_price' ), 0, '.', ' ' ) . '<span class = "cwp-more-info-prices__currency"><i class = "fas fa-ruble-sign"></i></span>';
		}	else {
			$product_price_old = '';
		}

		// Actual price.
		if ( fw_get_db_post_option( $product_id, 'new_price' ) ) {
			/**
			 * RUBLE icon for currency (from Font Awesome Icons).
			 * @link https://fontawesome.com/icons
			 */
			$product_price_new = number_format( fw_get_db_post_option( $product_id, 'new_price' ), 0, '.', ' ' ) . '<span class = "cwp-more-info-prices__currency"><i class = "fas fa-ruble-sign"></i></span>';
		}	else {
			$product_price_new = '';
		}

		// Product type.
		if ( fw_get_db_post_option( $product_id, 'product_type' ) ) {
			/**
			 * Here and after BULLSEYE icon to list items (from Font Awesome Icons).
			 * @link https://fontawesome.com/icons
			 */
			$product_type = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Тип:', 'mebel-laim' ) . '</span>' .
							'<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'product_type' ) ) . '</span>';
		}	else {
			$product_type = '';
		}

		// Product material.
		if ( fw_get_db_post_option( $product_id, 'material' ) ) {
			$product_material = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Материал:', 'mebel-laim' ) . '</span>' .
								'<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'material' ) ) . '</span>';
		}	else {
			$product_material = '';
		}

		// Product width.
		if ( fw_get_db_post_option( $product_id, 'width' ) ) {
			$product_width = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Длина:', 'mebel-laim' ) . '</span>' .
							 '<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%f', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'width' ) ) . '</span>';
		}	else {
			$product_width = '';
		}

		// Product height.
		if ( fw_get_db_post_option( $product_id, 'height' ) ) {
			$product_height = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Высота:', 'mebel-laim' ) . '</span>' .
							  '<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%f', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'height' ) ) . '</span>';
		}	else {
			$product_height = '';
		}

		// Product depth.
		if ( fw_get_db_post_option( $product_id, 'depth' ) ) {
			$product_depth = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Глубина:', 'mebel-laim' ) . '</span>' .
							 '<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%f', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'depth' ) ) . '</span>';
		}	else {
			$product_depth = '';
		}

		// Product more features.
		if ( fw_get_db_post_option( $product_id, 'more_features' ) ) {
			$product_text = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Дополнительная информация:', 'mebel-laim' ) . '</span>' .
							'<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'more_features' ) ) . '</span>';
		}	else {
			$product_text = '';
		}

		// Number of products per pack.
		if ( fw_get_db_post_option( $product_id, 'number_per_pack' ) ) {
			$number_per_pack = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Единиц товара в упаковке:', 'mebel-laim' ) . '</span>' .
							   '<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%d', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'number_per_pack' ) ) . '</span>';
		}	else {
			$number_per_pack = '';
		}

		// Brand name.
		if ( fw_get_db_post_option( $product_id, 'brand_name' ) ) {
			$brand_name = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Производитель:', 'mebel-laim' ) . '</span>' .
						  '<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'brand_name' ) ) . '</span>';
		}	else {
			$brand_name = '';
		}

		// Country of manufacture.
		if ( fw_get_db_post_option( $product_id, 'country_of_manufacture' ) ) {
			$country_of_manufacture = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Страна производства:', 'mebel-laim' ) . '</span>' .
							   		  '<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'country_of_manufacture' ) ) . '</span>';
		}	else {
			$country_of_manufacture = '';
		}

		// Guarantee.
		if ( fw_get_db_post_option( $product_id, 'guarantee' ) ) {
			$guarantee = '<span class = "cwpgt-product__label"><i class = "fas fa-bullseye cwpgt-more-info__icon"></i>' . esc_html__( 'Гарантия:', 'mebel-laim' ) . '</span>' .
					     '<span class = "cwpgt-product__value">' . sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'guarantee' ) ) . '</span>';
		}	else {
			$guarantee = '';
		}

		// Success ajax message.
		wp_send_json_success(
			array(
				'product'		=> get_the_permalink( $product_id ),
				'title'			=> $product_title,
				'thumbnail' 	=> $product_image,
				'more_images'	=> $more_product_images_array,
				'colors'		=> $product_colors_array,
				'old_price' 	=> $product_price_old,
				'new_price' 	=> $product_price_new,
				'type'			=> $product_type,
				'material'		=> $product_material,
				'width'			=> $product_width,
				'height'		=> $product_height,
				'depth'			=> $product_depth,
				'text'			=> $product_text,
				'per_pack'		=> $number_per_pack,
				'brand'			=> $brand_name,
				'manufacture'	=> $country_of_manufacture,
				'guarantee'		=> $guarantee,
				'message'		=> __( 'Дополнительные данные товара успешно получены.', 'mebel-laim' )
			)
		);
    }

    /**
	 * Change sorting type.
	 */
    public function _cwpgt_apply_filters() {
    	$products_per_page = $this->clean_value( $_POST['products_per_page'] );	// Getting products per page count.
    	$new_term = $this->clean_value( $_POST['term'] );	// Getting new term.
    	$new_sort = $this->clean_value( $_POST['sort'] );	// Getting new sorting type.
    	$min_sort = $this->clean_value( $_POST['min'] );	// Getting new min price value.
    	$max_sort = $this->clean_value( $_POST['max'] );	// Getting new max price value.

		if ( empty( $new_term ) ||
			 empty( $new_sort ) ||
			 empty( $min_sort ) ||
			 empty( $max_sort ) ) {	// If some param or sorting type is empty.
			wp_send_json_error(	// Sending error message and exiting function.
				array(
					'message'	=> __( 'Нужные данные не переданы.', 'mebel-laim' )
				)
			);
		}

		if ( !is_numeric( $min_sort ) ||
			 !is_numeric( $max_sort ) ) {	// If min or max price is not numeric.
			wp_send_json_error(	// Sending error message and exiting function.
				array(
					'message'	=> __( 'Цена не является числом.', 'mebel-laim' )
				)
			);
		}

		if ( ( $min_sort > $max_sort ) ||
			 ( $min_sort < 0 ) ||
			 ( $max_sort < 0 ) ) {	// If min price larger than max price.
			wp_send_json_error(	// Sending error message and exiting function.
				array(
					'message'	=> __( 'Проверьте правильность введенного диапазона цен.', 'mebel-laim' )
				)
			);
		}

		/**
		 * If all previous is OK - prepairing new HTML structure for sending.
		 *
		 * Check what new sorting type we've got.
		 */
		$new_query = $this->switch_sorting_type( $new_sort, $new_term, $products_per_page, $min_sort, $max_sort, 0 );

		$new_structure = '';	// Empty variable for new HTML structure to be sent.

		// If our new query has posts (products).
		if ( $new_query->have_posts() ) {
			while( $new_query->have_posts() ) : $new_query->the_post();
				$id = get_the_ID();
				$new_structure .= '
					<div class = "fw-col-md-3 fw-col-sm-4">
						<div class = "cwpgt-product">
							<div class = "cwpgt-product-image" style = "background-image: url(' . esc_attr( get_the_post_thumbnail_url( $id, 'medium' ) ) . ')">
								<!-- Overlays are showing when PLUS icon is clicked. -->
								<div class = "cwpgt-button-overlay-before_brand"></div>
								<div class = "cwpgt-button-overlay-before"></div>

								<!-- Buttons are showing when PLUS icon is clicked. -->
								<div class = "cwpgt-button-overlay animated">
									<a class = "button cwpgt-more-info-button animated" href = "#" data-id = "' . esc_attr( $id ) . '">' .
										esc_html__( 'Больше информации', 'mebel-laim' ) .
									'</a>
									<a class = "button animated" href = "#" style = "animation-delay: 150ms">' .
										esc_html__( 'Быстрый заказ', 'mebel-laim' ) .
									'</a>
									<a class = "button animated" href = "#" style = "animation-delay: 300ms">' .
										esc_html__( 'Добавить в корзину', 'mebel-laim' ) .
									'</a>
									<a class = "button animated" href = "' . esc_url( get_the_permalink() ) . '" style = "animation-delay: 450ms">' .
										esc_html__( 'Перейти к товару', 'mebel-laim' ) .
									'</a>
								</div>

								<!-- PLUS icon. -->
								<a href = "#" class = "cwpgt-product-actions" title = "' . esc_html__( 'Действия', 'mebel-laim' ) . '" data-clicked = "0">
									<!-- Horizontal line. -->
					 				<span class = "cwpgt-product-actions__line"></span>
					 				<!-- Vertical line. -->
					 				<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
					 			</a>
							</div><!-- .cwpgt-product-image -->

							<div class = "cwpgt-product-term">';
					 			// Getting all terms of current product in taxonomy "products".
					 			$terms = wp_get_post_terms( $id, 'products' );

					 			// Searching if one of terms has no child terms - this is the lowest term, we need it.
					 			foreach ( $terms as $term ) {
					 				if ( count( get_term_children( $term->term_id, 'products' ) ) === 0 ) {
					 					$new_structure .= '<a class = "cwpgt-product-term__link" href = "' . esc_url( get_term_link( $term->term_id, 'products' ) ) . '">' . sprintf( esc_html__( '%s', 'mebel-laim' ), $term->name ) . '</a>';
					 					break;
					 				}
					 			}
					 		$new_structure .= '</div><!-- .cwp-slide-term -->

							<div class = "cwpgt-product-info">
								<div class = "cwpgt-product-title">
						 			<h3 class = "cwpgt-product-text__header">' .
						 				get_the_title() .
						 			'</h3>
						 		</div>

						 		<div class = "cwpgt-product-price">';
					 				/**
					 				 * If product new price is not empty.
					 				 * 
					 				 * @ Product -> Prices -> New Price.
					 				 */
						 			if ( fw_get_db_post_option( $id, 'new_price' ) ) {
						 				$new_structure .= '<span class = "cwpgt-product-price__new">' .
						 					number_format( fw_get_db_post_option( $id, 'new_price' ), 0, '.', ' ' ) . '
						 					<!--
						 					RUBLE icon for currency (from Font Awesome Icons).
						 					@link https://fontawesome.com/icons
						 					-->
						 					<span class = "cwpgt-product-price__currency"><i class = "fas fa-ruble-sign"></i></span>
						 				</span>';
						 			}
						 			$new_structure .= '
						 		</div><!-- .cwpgt-product-price -->
							</div><!-- .cwpgt-product-info -->
						</div><!-- .cwpgt-product -->
					</div><!-- .fw-col-md-3 -->
				';
			endwhile;
		}	else {
			$new_structure = esc_html__( 'По заданным критериям поиска товаров не найдено.', 'mebel-laim' );
		}

		if ( $new_query->max_num_pages > 1 ) {
			$paginate_links = '
				<a href = "#" class = "page-numbers cwpgt-pagination__previous">
					<span class = "cwpgt-product-actions__line"></span>
					<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
				</a>' .
				paginate_links(
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
		        ) .
		        '<a href = "#" class = "page-numbers cwpgt-pagination__next">
					<span class = "cwpgt-product-actions__line"></span>
					<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
				</a>';
		}
		wp_reset_query();	// Clearing query ($new_query) for correct work of other loops.

		wp_send_json_success(
			array(
				'structure'		=> $new_structure,
				'pagination'	=> $paginate_links,
				'message'		=> esc_html__( 'Сортировка выполнена успешно!', 'mebel-laim' )
			)
		);
    }

    /**
	 * Pagination page numbers clicks.
	 */
    public function _cwpgt_pagination_number_click() {
    	$products_term = $this->clean_value( $_POST['products_term'] );	// Getting products current term.
    	$products_per_page = $this->clean_value( $_POST['products_per_page'] );	// Getting products per page count.
    	$products_current_page = $this->clean_value( $_POST['products_current_page'] );	// Getting current pagination page.

    	$new_sort = $this->clean_value( $_POST['sort'] );	// Getting new sorting type.
    	$min_sort = $this->clean_value( $_POST['min'] );	// Getting new min price value.
    	$max_sort = $this->clean_value( $_POST['max'] );	// Getting new max price value.

    	if ( empty( $products_term ) ||
    		 empty( $products_per_page ) ||
			 empty( $products_current_page ) ) {	// If some values are empty.
			wp_send_json_error(	// Sending error message and exiting function.
				array(
					'message'	=> esc_html__( 'Переданные данные частично или полностью пусты. Выход из функции.', 'mebel-laim' )
				)
			);
		}

		if ( !is_numeric( $products_per_page ) ||
			 !is_numeric( $products_current_page ) ) {	// If some values are not numeric format.
			wp_send_json_error(	// Sending error message and exiting function.
				array(
					'message'	=> esc_html__( 'Переданные данные частично или полностью имеют некорректный формат. Выход из функции.', 'mebel-laim' )
				)
			);
		}

		// Page can not be null or less. Set it to 1 in such case.
		if ( $products_current_page < 1 ) {
			$products_current_page = 1;
		}

		if ( empty( $new_sort ) ||
			 empty( $min_sort ) ||
			 empty( $max_sort ) ) {	// If some param or sorting type is empty.
			wp_send_json_error(	// Sending error message and exiting function.
				array(
					'message'	=> esc_html__( 'Нужные данные не переданы.', 'mebel-laim' )
				)
			);
		}

		if ( !is_numeric( $min_sort ) ||
			 !is_numeric( $max_sort ) ) {	// If min or max price is not numeric.
			wp_send_json_error(	// Sending error message and exiting function.
				array(
					'message'	=> esc_html__( 'Цена не является числом.', 'mebel-laim' )
				)
			);
		}

		if ( ( $min_sort > $max_sort ) ||
			 ( $min_sort < 0 ) ||
			 ( $max_sort < 0 ) ) {	// If min price larger than max price.
			wp_send_json_error(	// Sending error message and exiting function.
				array(
					'message'	=> esc_html__( 'Проверьте правильность введенного диапазона цен.', 'mebel-laim' )
				)
			);
		}

		// Finding maximum page count for this slug and parameters.
		$term_info = get_term_by( 'slug', $products_term, 'products' ); // Current term info.
		$term_products_count = $term_info->count;	// Products count in it.

		// Products offset count formula.
		$products_offset = ( $products_current_page * $products_per_page ) - $products_per_page;

		if ( $products_offset >= $term_products_count ) {	// If offset is too large.
			$products_offset -= $products_per_page;	// Go back on one page.
		}

		/**
		 * If all previous is OK - prepairing new HTML structure for sending.
		 *
		 * Check what new sorting type we've got.
		 */
		$new_query = $this->switch_sorting_type( $new_sort, $products_term, $products_per_page, $min_sort, $max_sort, $products_offset );

		// If our new query has posts (products).
		if ( $new_query->have_posts() ) {
			if ( $products_current_page > $new_query->max_num_pages ) {
				$products_current_page = $new_query->max_num_pages;
			}

			$output = ''; // Empty variable for next HTML.

			while( $new_query->have_posts() ) : $new_query->the_post();
				$id = get_the_ID();
				$output .= '
					<div class = "fw-col-md-3 fw-col-sm-4">
						<div class = "cwpgt-product">
							<div class = "cwpgt-product-image" style = "background-image: url(' . esc_url( get_the_post_thumbnail_url( $id, 'medium' ) ) . ')">
								<div class = "cwpgt-button-overlay-before_brand"></div>
								<div class = "cwpgt-button-overlay-before"></div>

								<div class = "cwpgt-button-overlay animated">
									<a class = "button cwpgt-more-info-button animated" href = "#" data-id = "' . esc_attr( $id ) . '">' .
										esc_html__( 'Больше информации', 'mebel-laim' ) .
									'</a>
									<a class = "button animated" href = "#" style = "animation-delay: 150ms">' .
										esc_html__( 'Быстрый заказ', 'mebel-laim' ) .
									'</a>
									<a class = "button animated" href = "#" style = "animation-delay: 300ms">' .
										esc_html__( 'Добавить в корзину', 'mebel-laim' ) .
									'</a>
									<a class = "button animated" href = "' . esc_url( get_the_permalink( $id ) ) . '" style = "animation-delay: 450ms">' .
										esc_html__( 'Перейти к товару', 'mebel-laim' ) .
									'</a>
								</div>

								<a href = "#" class = "cwpgt-product-actions" title = "' . esc_html__( 'Действия', 'mebel-laim' ) . '" data-clicked = "0">
					 				<span class = "cwpgt-product-actions__line"></span>
					 				<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
					 			</a>
							</div>

							<div class = "cwpgt-product-term">';
					 			// Getting all terms of current product in taxonomy "products".
					 			$terms = wp_get_post_terms( $id, 'products' );

					 			// Searching if one of terms has no child terms - this is the lowest term, we need it.
					 			foreach ( $terms as $term ) {
					 				if ( count( get_term_children( $term->term_id, 'products' ) ) === 0 ) {
					 					$output .= '<a class = "cwpgt-product-term__link" href = "' . esc_url( get_term_link( $term->term_id, 'products' ) ) . '">' . sprintf( esc_html__( '%s', 'mebel-laim' ), $term->name ) . '</a>';
					 					break;
					 				}
					 			}
					 		$output .= '</div>

							<div class = "cwpgt-product-info">
								<div class = "cwpgt-product-title">
						 			<h3 class = "cwpgt-product-text__header">' .
						 				get_the_title( $id ) . '
						 			</h3>
						 		</div>

						 		<div class = "cwpgt-product-price">';
					 				/**
					 				 * If product new price is not empty.
					 				 * 
					 				 * @ Product -> Prices -> New Price.
					 				 */
						 			if ( fw_get_db_post_option( $id, 'new_price' ) ) {
						 				$output .= '<span class = "cwpgt-product-price__new">' .
						 					number_format( fw_get_db_post_option( $id, 'new_price' ), 0, '.', ' ' ) .
						 					'<span class = "cwpgt-product-price__currency"><i class = "fas fa-ruble-sign"></i></span>
						 				</span>';
						 			}
						 		$output .= '</div>
							</div>
						</div>
					</div>';
			endwhile;
		}	else {
			$output = esc_html__( 'По заданным критериям поиска товаров не найдено.', 'mebel-laim' );
		}

		if ( $new_query->max_num_pages > 1 ) {
			$paginate_links = '
				<a href = "#" class = "page-numbers cwpgt-pagination__previous">
					<span class = "cwpgt-product-actions__line"></span>
					<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
				</a>' .
				paginate_links(
		        	array(
			            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			            'total'        => $new_query->max_num_pages,
			            'current'      => $products_current_page,
			            'format'       => '?paged=%#%',
			            'show_all'     => false,
			            'type'         => 'plain',
			            'end_size'     => 2,
			            'mid_size'     => 1,
			            'prev_next'    => false,
			            'add_args'     => false,
			            'add_fragment' => ''
		        	)
		        ) .
		        '<a href = "#" class = "page-numbers cwpgt-pagination__next">
					<span class = "cwpgt-product-actions__line"></span>
					<span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>
				</a>';
		}
		wp_reset_query();	// Clearing query ($new_query) for correct work of other loops.

		wp_send_json_success(
			array(
				'structure'		=> $output,
				'pagination'	=> $paginate_links,
				'message'		=> sprintf( esc_html__( 'Успешная загрузка страницы товаров #%d', 'mebel-laim' ), $products_current_page )
			)
		);
    }
}