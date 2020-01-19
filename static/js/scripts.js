jQuery( function( $ ) {
	var isActiveAjax = false;

	/**
	 * Preloader appearing function.
	 *
	 * @param preloaderClass - class name of preloader wrapper to remove it after loading data.
	 */
	function appendPreloader( preloaderClass, iconClass ) {
		$( 'body' ).append(
			'<div class = "' + preloaderClass + ' animated fadeIn">' +
				'<i class = "' + iconClass + ' product-more-info-preloader__icon"></i>' +
			'</div>'
		);
	}

	/**
	 * When all page is loaded.
	 */
	$( document ).ready( function() {
		var clicked, owl;
		var data; // For Ajax request.
		var moreImagesNewActiveImage;	// New image source link in more product images slider.
		var term;	// Sorting by term.
		var sort;	// Sorting by sorting type.
		var minPrice, maxPrice;	// Sorting by price.
		var paginationLink, productsTerm, productsPerPage, productsCurrentPage;	// Ajax products pagination.
		var iconClass = $( '.term-products-wrapper' ).attr( 'data-preloader' );

		/**
		 * Product term list item click.
		 */
		$( '.terms' ).on( 'click', '.term', function( e ) {
			e.preventDefault();
			$( '.term' ).removeClass( 'sort_active' );	// Remove active class from all list items.
			$( this ).addClass( 'sort_active' );	// Add active class to current active item.
		} );

		/**
		 * Product sorting types list item click.
		 */
		$( '.sorting' ).on( 'click', '.sort', function( e ) {
			e.preventDefault();
			$( '.sort' ).removeClass( 'sort_active' );	// Remove active class from all list items.
			$( this ).addClass( 'sort_active' );	// Add active class to current active item.
		} );

		// If the letter is not digit then display error and don't type anything.
		$( '.price-sorting__input' ).keypress( function( e ) {
			if ( e.which != 8 && e.which != 0 && ( e.which < 48 || e.which > 57 ) ) {
				$( '.price-sorting' ).append( '<span class = "sorting-message sorting-message_error">Только цифры!</span>' );	// Show error message.
				setTimeout(
					function() {
						$( '.sorting-message' ).remove();	// Remove preloader from DOM.
					},
					5000
				);
			   	return false;
			}

			if ( ( $( this ).val() == 0 ) || ( $( this ).val() == '' ) ) {
				$( this ).val( 1 );
			}
		} );

		// When input losts its focus, check its value.
		$( '.price-sorting__input' ).focusout( function( e ) {
			if ( ( $( this ).val() <= 0 ) || ( $( this ).val() == '' ) ) {
				$( this ).val( 1 );
			}
		} );

		/**
		 * Apply filters.
		 */
		$( '.price-sorting' ).on( 'click', '.apply-filters', function( e ) {
			if ( !isActiveAjax ) {	// If user can use ajax.
				isActiveAjax = true;	// Ajax for other actions is blocked.
				term = $( '.term.sort_active' ).attr( 'data-term' );	// Get term slug from data-attribute.
				sort = $( '.sort.sort_active' ).attr( 'data-sort' );	// Get sorting type from data-attribute.
				minPrice = $( '.price-sorting__input_min' ).val();
				maxPrice = $( '.price-sorting__input_max' ).val();
				paginationLink = $( this );
				productsPerPage = parseInt( paginationLink.closest( '.fw-container' ).find( '.pagination' ).attr( 'data-per-page' ) );

				// Preloader appears.
				appendPreloader( 'product-more-info-preloader', iconClass );

				ajaxData = {	// Data for Ajax request.
					action				: '_apply_filters',
					products_per_page	: productsPerPage,
					term				: term,
					sort 				: sort,
					min 				: minPrice,
					max 				: maxPrice
				};

				$.post( cwpAjax.ajaxurl, ajaxData, function( data ) {	// Ajax post request.
					$( '.product-more-info-preloader' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide preloader.
					// Delay 1 second to play animation, then remove preloader.
					setTimeout(
						function() {
							$( '.product-more-info-preloader' ).remove();	// Remove preloader from DOM.
						},
						1000
					);

					if ( $( 'span' ).hasClass( 'sorting-message' ) ) {
						$( '.sorting-message' ).remove(); // Clear field for response message text. It will append again.
					}

					switch ( data.success ) {	// Checking ajax response.
						case true: 	// If ajax response is success.
							if ( data.data.structure != '' ) {	// If new HTML structure is not empty.
								paginationLink.closest( '.fw-container' ).find( '.term-products-wrapper' ).html( data.data.structure );
							}

							if ( data.data.pagination != '' ) {	// If new pagination structure is not empty.
								paginationLink.closest( '.fw-container' ).find( '.pagination' ).html( data.data.pagination );
							}
							isActiveAjax = false;	// User can use ajax ahead.
			    			break;

						case false: 	// If we have some errors.
			    			$( '.price-sorting' ).append( '<span class = "sorting-message sorting-message_error">' + data.data.message + '</span>' );	// Show error message.
			    			setTimeout(
								function() {
									$( '.sorting-message' ).remove();	// Remove preloader from DOM.
								},
								5000
							);
			    			isActiveAjax = false;	// User can use ajax ahead.
			    			break;

			    		default: 	// Default variant.
			    			console.log( 'Unknown error!' );	// Show message of unknown error in console.
			    			isActiveAjax = false;	// User can use ajax ahead.
			    			break;
					}
				} );
			}
		} );

		/**
		 * Pagination. Page number click.
		 */
		$( '.pagination' ).on( 'click', 'a.page-numbers', function( e ) {
			e.preventDefault();

			if ( !isActiveAjax ) {	// If user can use ajax.
				isActiveAjax = true;	// Ajax for other actions is blocked.
				paginationLink = $( this );
				productsTerm = $( '.term.sort_active' ).attr( 'data-term' );	// Get term slug from data-attribute.
				productsPerPage = parseInt( paginationLink.closest( '.pagination' ).attr( 'data-per-page' ) );

				sort = $( '.sort.sort_active' ).attr( 'data-sort' );	// Get sorting type from data-attribute.
				minPrice = $( '.price-sorting__input_min' ).val();
				maxPrice = $( '.price-sorting__input_max' ).val();

				if ( paginationLink.hasClass( 'prev' ) ) {
					productsCurrentPage = parseInt( paginationLink.closest( '.pagination' ).find( '.page-numbers.current' ).html() ) - 1;
				}	else if ( paginationLink.hasClass( 'next' ) ) {
					productsCurrentPage = parseInt( paginationLink.closest( '.pagination' ).find( '.page-numbers.current' ).html() ) + 1;
				}	else {
					productsCurrentPage = parseInt( paginationLink.html() );
				}

				// Preloader appears.
				appendPreloader( 'product-more-info-preloader', iconClass );

				ajaxData = {
					action 					: '_pagination_number_click',
					products_term			: productsTerm,
					products_per_page		: productsPerPage,
					products_current_page	: productsCurrentPage,
					sort 					: sort,
					min 					: minPrice,
					max 					: maxPrice
				};

				$.post( cwpAjax.ajaxurl, ajaxData, function( data ) {	// Ajax post request.
					switch ( data.success ) {	// Checking ajax response.
						case true: 	// If ajax response is success.
							console.log( data.data.message );	// Show success message in console.
							$( '.product-more-info-preloader' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide preloader.

							// Delay 1 second to play animation, then remove preloader.
							setTimeout(
								function() {
									$( '.product-more-info-preloader' ).remove();	// Remove preloader from DOM.
								},
								1000
							);

							if ( data.data.structure != '' ) {	// If new HTML structure is not empty.
								$( '.term-products-wrapper' ).html( data.data.structure );
							}

							if ( data.data.pagination != '' ) {	// If new pagination structure is not empty.
								$( '.pagination' ).html( data.data.pagination );
							}

							// Scroll to the top of the products list.
							$( 'html, body' ).animate( {
						        scrollTop: $( '.term-products-wrapper' ).offset().top
						    }, 'slow' );

							isActiveAjax = false;	// User can use ajax ahead.
			    			break;

						case false: 	// If we have some errors.
			    			console.log( data.data.message );	// Show errors in console.
			    			$( '.product-more-info-preloader' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide preloader.

							// Delay 1 second to play animation, then remove preloader.
							setTimeout(
								function() {
									$( '.product-more-info-preloader' ).remove();	// Remove preloader from DOM.
								},
								1000
							);
			    			isActiveAjax = false;	// User can use ajax ahead.
			    			break;
					}
				} );
			}
		} );

	} );

} );