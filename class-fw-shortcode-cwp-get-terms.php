<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Shortcode_CWP_Get_Terms extends FW_Shortcode
{
	private $taxonomy = 'showcase';

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
								'taxonomy'	=> $this->taxonomy,	// Taxonomy name.
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
								'taxonomy'	=> $this->taxonomy,	// Taxonomy name.
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
								'taxonomy'	=> $this->taxonomy,	// Taxonomy name.
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
								'taxonomy'	=> $this->taxonomy,	// Taxonomy name.
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
								'taxonomy'	=> $this->taxonomy,	// Taxonomy name.
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
								'taxonomy'	=> $this->taxonomy,	// Taxonomy name.
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
								'taxonomy'	=> $this->taxonomy,	// Taxonomy name.
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
		// Change sorting type.
		add_action( 'wp_ajax__apply_filters', array( $this, '_apply_filters' ) );
		add_action( 'wp_ajax_nopriv__apply_filters', array( $this, '_apply_filters' ) );

		// Pagination page numbers clicks.
		add_action( 'wp_ajax__pagination_number_click', array( $this, '_pagination_number_click' ) );
		add_action( 'wp_ajax_nopriv__pagination_number_click', array( $this, '_pagination_number_click' ) );
    }

    /**
	 * Change sorting type.
	 */
    public function _apply_filters() {
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
						<div class = "product">
							<div class = "product-image" style = "background-image: url(' . esc_attr( get_the_post_thumbnail_url( $id, 'medium' ) ) . ')">
								<!-- Overlays are showing when PLUS icon is clicked. -->
								<div class = "button-overlay-before_brand"></div>
								<div class = "button-overlay-before"></div>

								<!-- Buttons are showing when PLUS icon is clicked. -->
								<div class = "button-overlay animated">
									<a class = "button more-info-button animated" href = "#" data-id = "' . esc_attr( $id ) . '">' .
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
								<a href = "#" class = "product-actions" title = "' . esc_html__( 'Действия', 'mebel-laim' ) . '" data-clicked = "0">
									<!-- Horizontal line. -->
					 				<span class = "product-actions__line"></span>
					 				<!-- Vertical line. -->
					 				<span class = "product-actions__line product-actions__line_cross"></span>
					 			</a>
							</div><!-- .product-image -->

							<div class = "product-term">';
					 			// Getting all terms of current product in taxonomy "products".
					 			$terms = wp_get_post_terms( $id, $this->taxonomy );

					 			// Searching if one of terms has no child terms - this is the lowest term, we need it.
					 			foreach ( $terms as $term ) {
					 				if ( count( get_term_children( $term->term_id, $this->taxonomy ) ) === 0 ) {
					 					$new_structure .= '<a class = "product-term__link" href = "' . esc_url( get_term_link( $term->term_id, $this->taxonomy ) ) . '">' . sprintf( esc_html__( '%s', 'mebel-laim' ), $term->name ) . '</a>';
					 					break;
					 				}
					 			}
					 		$new_structure .= '</div><!-- .cwp-slide-term -->

							<div class = "product-info">
								<div class = "product-title">
						 			<h3 class = "product-text__header">' .
						 				get_the_title() .
						 			'</h3>
						 		</div>

						 		<div class = "product-price">';
					 				/**
					 				 * If product new price is not empty.
					 				 * 
					 				 * @ Product -> Prices -> New Price.
					 				 */
						 			if ( fw_get_db_post_option( $id, 'new_price' ) ) {
						 				$new_structure .= '<span class = "product-price__new">' .
						 					number_format( fw_get_db_post_option( $id, 'new_price' ), 0, '.', ' ' ) . '
						 					<!--
						 					RUBLE icon for currency (from Font Awesome Icons).
						 					@link https://fontawesome.com/icons
						 					-->
						 					<span class = "product-price__currency"><i class = "fas fa-ruble-sign"></i></span>
						 				</span>';
						 			}
						 			$new_structure .= '
						 		</div><!-- .product-price -->
							</div><!-- .product-info -->
						</div><!-- .product -->
					</div><!-- .fw-col-md-3 -->
				';
			endwhile;
		}	else {
			$new_structure = esc_html__( 'По заданным критериям поиска товаров не найдено.', 'mebel-laim' );
		}

		if ( $new_query->max_num_pages > 1 ) {
			$paginate_links = '
				<a href = "#" class = "page-numbers prev">
					<span class = "product-actions__line"></span>
					<span class = "product-actions__line product-actions__line_cross"></span>
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
		        '<a href = "#" class = "page-numbers next">
					<span class = "product-actions__line"></span>
					<span class = "product-actions__line product-actions__line_cross"></span>
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
    public function _pagination_number_click() {
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
		$term_info = get_term_by( 'slug', $products_term, $this->taxonomy ); // Current term info.
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
						<div class = "product">
							<div class = "product-image" style = "background-image: url(' . esc_url( get_the_post_thumbnail_url( $id, 'medium' ) ) . ')">
								<div class = "button-overlay-before_brand"></div>
								<div class = "button-overlay-before"></div>

								<div class = "button-overlay animated">
									<a class = "button more-info-button animated" href = "#" data-id = "' . esc_attr( $id ) . '">' .
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

								<a href = "#" class = "product-actions" title = "' . esc_html__( 'Действия', 'mebel-laim' ) . '" data-clicked = "0">
					 				<span class = "product-actions__line"></span>
					 				<span class = "product-actions__line product-actions__line_cross"></span>
					 			</a>
							</div>

							<div class = "product-term">';
					 			// Getting all terms of current product in taxonomy "showcase".
					 			$terms = wp_get_post_terms( $id, $this->taxonomy );

					 			// Searching if one of terms has no child terms - this is the lowest term, we need it.
					 			foreach ( $terms as $term ) {
					 				if ( count( get_term_children( $term->term_id, $this->taxonomy ) ) === 0 ) {
					 					$output .= '<a class = "product-term__link" href = "' . esc_url( get_term_link( $term->term_id, $this->taxonomy ) ) . '">' . sprintf( esc_html__( '%s', 'mebel-laim' ), $term->name ) . '</a>';
					 					break;
					 				}
					 			}
					 		$output .= '</div>

							<div class = "product-info">
								<div class = "product-title">
						 			<h3 class = "product-text__header">' .
						 				get_the_title( $id ) . '
						 			</h3>
						 		</div>

						 		<div class = "product-price">';
					 				/**
					 				 * If product new price is not empty.
					 				 * 
					 				 * @ Product -> Prices -> New Price.
					 				 */
						 			if ( fw_get_db_post_option( $id, 'new_price' ) ) {
						 				$output .= '<span class = "product-price__new">' .
						 					number_format( fw_get_db_post_option( $id, 'new_price' ), 0, '.', ' ' ) .
						 					'<span class = "product-price__currency"><i class = "fas fa-ruble-sign"></i></span>
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
				<a href = "#" class = "page-numbers prev">
					<span class = "product-actions__line"></span>
					<span class = "product-actions__line product-actions__line_cross"></span>
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
		        '<a href = "#" class = "page-numbers next">
					<span class = "product-actions__line"></span>
					<span class = "product-actions__line product-actions__line_cross"></span>
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