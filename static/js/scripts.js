jQuery( function( $ ) {
	var isActiveAjax = false;

	/**
	 * Preloader appearing function.
	 *
	 * @param preloaderClass - class name of preloader wrapper to remove it after loading data.
	 */
	function appendPreloader( preloaderClass ) {
		$( 'body' ).append(
			'<div class = "' + preloaderClass + ' animated fadeIn">' +
				'<i class = "fas fa-spinner cwpgt-product-more-info-preloader__icon"></i>' +
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

		/**
		 * Product plus click.
		 */
		$( '.term-products-wrapper' ).on( 'click', '.cwpgt-product-actions', function( e ) {
			e.preventDefault();
			btn = $( this );
			slide = btn.closest( '.cwpgt-product' );
			clicked = btn.attr( 'data-clicked' );

			if ( clicked == 0 ) {
				// Display current overlay.
				$( this ).addClass( 'cwpgt-product-actions_active' );
				$( '.cwpgt-button-overlay', slide ).css( 'display', 'grid' );

				// Overlays before buttons appearing.
				$( '.cwpgt-button-overlay-before_brand', slide ).addClass( 'cwpgt-button-overlay-before_active' );
				setTimeout( function() {
					$( '.cwpgt-button-overlay-before', slide ).addClass( 'cwpgt-button-overlay-before_active' );
				}, 50 );

				// Current overlay animation on show.
				setTimeout( function() {
					$( '.cwpgt-button-overlay', slide ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );
					$( '.cwpgt-button-overlay .button', slide ).removeClass( 'fadeOutUp' ).addClass( 'fadeInDown' );
					btn.attr( 'data-clicked', 1 );
				}, 1 );
			}	else {	// Close.
				$( this ).removeClass( 'cwpgt-product-actions_active' );
				$( '.cwpgt-button-overlay .button', slide ).removeClass( 'fadeInDown' ).addClass( 'fadeOutUp' );
				$( '.cwpgt-button-overlay', slide ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );

				setTimeout( function() {
					$( '.cwpgt-button-overlay-before', slide ).removeClass( 'cwpgt-button-overlay-before_active' );
				}, 300 );

				setTimeout( function() {
					$( '.cwpgt-button-overlay-before_brand', slide ).removeClass( 'cwpgt-button-overlay-before_active' );
				}, 350 );

				setTimeout( function() {
					$( '.cwpgt-button-overlay', slide ).css( 'display', 'none' );
					btn.attr( 'data-clicked', 0 );
				}, 1000 );
			}
		} );

		/**
		 * Show more info about product.
		 */
		$( '.term-products-wrapper' ).on( 'click', '.cwpgt-more-info-button', function( e ) {
			e.preventDefault();

			if ( !isActiveAjax ) {	// If user can use ajax.
				isActiveAjax = true;	// Ajax for other actions is blocked.

				// Closing buttons wrapper.
				$( '.cwpgt-product-actions' ).removeClass( 'cwpgt-product-actions_active' );
				$( '.cwpgt-button-overlay .button', slide ).removeClass( 'fadeInDown' ).addClass( 'fadeOutUp' );
				$( '.cwpgt-button-overlay', slide ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );

				setTimeout( function() {
					$( '.cwpgt-button-overlay-before', slide ).removeClass( 'cwpgt-button-overlay-before_active' );
				}, 300 );

				setTimeout( function() {
					$( '.cwpgt-button-overlay-before_brand', slide ).removeClass( 'cwpgt-button-overlay-before_active' );
				}, 350 );

				setTimeout( function() {
					$( '.cwpgt-button-overlay', slide ).css( 'display', 'none' );
					btn.attr( 'data-clicked', 0 );
				}, 1000 );

				// Preloader appears.
				appendPreloader( 'cwpgt-product-more-info-preloader' );

				productId = $( this ).attr( 'data-id' );	// Get product ID from .cwp-slide-more-info-button data-id attribute.
				ajaxData = {
					action 			: '_cwpgt_show_more',
					product_id		: productId
				};

				$.post( cwpAjax.ajaxurl, ajaxData, function( data ) {	// Ajax post request.
					switch ( data.success ) {	// Checking ajax response.
						case true: 	// If ajax response is success.
							/**
							 * Filling all more product info fields with response data.
							 */
							if ( data.data.product != '' ) {	// If product id is not empty.
								$( '.button_go-to-product' ).attr( 'href', data.data.product );
							}

							if ( data.data.title != '' ) {	// If title is not empty.
								$( '.cwpgt-more-info__title' ).html( data.data.title );
							}

							if ( data.data.thumbnail != '' ) {	// If thumbnail is not empty.
								$( '.cwpgt-more-info-image-wrapper' ).css( 'background-image', 'url(' + data.data.thumbnail + ')' );
							}

							if ( data.data.more_images != '' ) {	// If more product images array is not empty.
								$( '.cwpgt-more-info-images' ).html( data.data.more_images );
								$( '.cwpgt-more-info-images' ).addClass( 'owl-carousel owl-theme' );

								/**
								 * Owl Slider for product images array.
								 */
								owl = $( '.cwpgt-more-info-images' );

								owl.owlCarousel( {
									autoplay 	: false,
									items 		: 12,
							    	loop 		: false,
								    margin 		: 0,
								    nav 		: true,
								    navText		: ['<span class = "cwpgt-product-actions__line"></span><span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>','<span class = "cwpgt-product-actions__line"></span><span class = "cwpgt-product-actions__line cwpgt-product-actions__line_cross"></span>'],
								    dots 		: false,
								    responsive	: {
								    	0: {
								    		items: 4
								    	},
								    	600: {
								    		items: 8
								    	},
								    	800: {
								    		items: 12
								    	}
								    }
							    } );
							}

							if ( data.data.colors != '' ) {	// If colors array is not empty.
								$( '.cwpgt-more-info-colors' ).html( data.data.colors );
							}

							if ( data.data.old_price != '' ) {	// If old price is not empty.
								$( '.cwpgt-more-info-prices__old' ).html( data.data.old_price );
							}

							if ( data.data.new_price != '' ) {	// If new price is not empty.
								$( '.cwpgt-more-info-prices__new' ).html( data.data.new_price );
							}

							if ( data.data.type != '' ) {	// If type is not empty.
								$( '.cwpgt-more-info-type' ).html( data.data.type );
							}

							if ( data.data.material != '' ) {	// If new price is not empty.
								$( '.cwpgt-more-info-material' ).html( data.data.material );
							}

							if ( data.data.width != '' ) {	// If width is not empty.
								$( '.cwpgt-more-info-width' ).html( data.data.width );
							}

							if ( data.data.height != '' ) {	// If height is not empty.
								$( '.cwpgt-more-info-height' ).html( data.data.height );
							}

							if ( data.data.depth != '' ) {	// If depth is not empty.
								$( '.cwpgt-more-info-depth' ).html( data.data.depth );
							}

							if ( data.data.text != '' ) {	// If text is not empty.
								$( '.cwpgt-more-info-text' ).html( data.data.text );
							}

							if ( data.data.per_pack != '' ) {	// If number of products per pack is not empty.
								$( '.cwpgt-more-info-number-per-pack' ).html( data.data.per_pack );
							}

							if ( data.data.manufacture != '' ) {	// If manufacture country is not empty.
								$( '.cwpgt-more-info-manufacture-country' ).html( data.data.manufacture );
							}

							if ( data.data.brand != '' ) {	// If brand country is not empty.
								$( '.cwpgt-more-info-brand-country' ).html( data.data.brand );
							}

							if ( data.data.guarantee != '' ) {	// If depth is not empty.
								$( '.cwpgt-more-info-guarantee' ).html( data.data.guarantee );
							}

							console.log( data.data.message );	// Show success message in console.

							$( '.cwpgt-product-more-info-preloader' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide preloader.
							$( '.cwpgt-more-info' ).removeClass( 'fadeOutLeft' ).addClass( 'fadeInLeft' );	// Remove animation hiding class.
							$( '.cwpgt-more-info-image-wrapper' ).removeClass( 'fadeOutRight' ).addClass( 'fadeInRight' );	// Remove animation hiding class.
							$( '.cwpgt-more-info-wrapper' ).css( 'display', 'grid' );	// Display more info block as CSS-grid.

							// Delay 100 ms after display wrapper to see correct animation.
							setTimeout(
								function() {
									$( '.cwpgt-more-info-wrapper' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );	// Show info wrapper with fade animation.
									$( '.cwpgt-more-info-item' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );	// Show info fields with fade animation.
								},
								100
							);
							// Delay 1 second to play animation, then remove preloader.
							setTimeout(
								function() {
									$( '.cwpgt-product-more-info-preloader' ).remove();	// Remove preloader from DOM.
								},
								1000
							);
							isActiveAjax = false;	// User can use ajax ahead.
			    			break;

						case false: 	// If we have some errors.
			    			console.log( data.data.message );	// Show errors in console.
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
		 * Close more info about product.
		 */
		$( 'body' ).on( 'click', '.close-popup', function( e ) {
			e.preventDefault();

			$( '.cwpgt-more-info' ).removeClass( 'fadeInLeft' ).addClass( 'fadeOutLeft' );	// Hide info with animation.
			$( '.cwpgt-more-info-image-wrapper' ).removeClass( 'fadeInRight' ).addClass( 'fadeOutRight' );	// Hide image with animation.
			$( '.cwpgt-more-info-wrapper' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide info wrapper with fade animation.
			setTimeout( function() {
				$( '.cwpgt-more-info-wrapper' ).css( 'display', 'none' );	// Hide more product info wrapper.
				$( '.cwpgt-more-info-image-wrapper' ).css( 'background-image', 'url()' );	// Remove main image from background.
				// Clearing all HTML blocks.
				$( '.cwpgt-more-info-item' ).html( '' );
				$( '.cwpgt-more-info-images' ).trigger( 'destroy.owl.carousel' );	// Destroy Owl Carousel.
			}, 1000 );
		} );

		/**
		 * Change image in more product images slider.
		 */
		$( '.cwpgt-more-info-images' ).on( 'click', '.cwpgt-more-info-image', function( e ) {
			e.preventDefault();

			$( '.cwpgt-more-info-image' ).removeClass( 'cwpgt-more-info-image_active' );	// Remove active class from all slider images.
			$( this ).addClass( 'cwpgt-more-info-image_active' );	// Add active class to current image thumbnail.
			moreImagesNewActiveImage = $( this ).attr( 'data-src' );	// Get new active slide image link.
			$( '.cwpgt-more-info-image-wrapper' ).css( 'background-image', 'url(' + moreImagesNewActiveImage + ')' );	// Set new active image as main big-size product image.
		} );

		/**
		 * Product color select.
		 */
		$( '.cwpgt-more-info-colors' ).on( 'click', '.cwpgt-more-info-colors-item', function( e ) {
			e.preventDefault();

			$( '.cwpgt-more-info-colors-item' ).removeClass( 'cwpgt-more-info-colors-item_active' );	// Remove active class from all product colors.
			$( this ).addClass( 'cwpgt-more-info-colors-item_active' );	// Add active class to current product color.
		} );

		/**
		 * Product term list item click.
		 */
		$( '.terms' ).on( 'click', '.term', function( e ) {
			e.preventDefault();
			$( '.term' ).removeClass( 'cwpgt_active' );	// Remove active class from all list items.
			$( this ).addClass( 'cwpgt_active' );	// Add active class to current active item.
		} );

		/**
		 * Product sorting types list item click.
		 */
		$( '.sorting' ).on( 'click', '.sort', function( e ) {
			e.preventDefault();
			$( '.sort' ).removeClass( 'cwpgt_active' );	// Remove active class from all list items.
			$( this ).addClass( 'cwpgt_active' );	// Add active class to current active item.
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
		$( '.price-sorting' ).on( 'click', '.cwpgt-apply-filters', function( e ) {
			if ( !isActiveAjax ) {	// If user can use ajax.
				isActiveAjax = true;	// Ajax for other actions is blocked.
				term = $( '.term.cwpgt_active' ).attr( 'data-term' );	// Get term slug from data-attribute.
				sort = $( '.sort.cwpgt_active' ).attr( 'data-sort' );	// Get sorting type from data-attribute.
				minPrice = $( '.price-sorting__input_min' ).val();
				maxPrice = $( '.price-sorting__input_max' ).val();
				paginationLink = $( this );
				productsPerPage = parseInt( paginationLink.closest( '.fw-container' ).find( '.cwpgt-pagination' ).attr( 'data-per-page' ) );

				// Preloader appears.
				appendPreloader( 'cwpgt-product-more-info-preloader' );

				ajaxData = {	// Data for Ajax request.
					action				: '_cwpgt_apply_filters',
					products_per_page	: productsPerPage,
					term				: term,
					sort 				: sort,
					min 				: minPrice,
					max 				: maxPrice
				};

				$.post( cwpAjax.ajaxurl, ajaxData, function( data ) {	// Ajax post request.
					$( '.cwpgt-product-more-info-preloader' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide preloader.
					// Delay 1 second to play animation, then remove preloader.
					setTimeout(
						function() {
							$( '.cwpgt-product-more-info-preloader' ).remove();	// Remove preloader from DOM.
						},
						1000
					);

					if ( $( 'span' ).hasClass( 'sorting-message' ) ) {
						$( '.sorting-message' ).remove(); // Clear field for response message text. It will append again.
					}

					switch ( data.success ) {	// Checking ajax response.
						case true: 	// If ajax response is success.
							$( '.price-sorting' ).append( '<span class = "sorting-message">' + data.data.message + '</span>' );	// Show success message.
							setTimeout(
								function() {
									$( '.sorting-message' ).remove();	// Remove preloader from DOM.
								},
								5000
							);

							if ( data.data.structure != '' ) {	// If new HTML structure is not empty.
								paginationLink.closest( '.fw-container' ).find( '.term-products-wrapper' ).html( data.data.structure );
							}

							if ( data.data.pagination != '' ) {	// If new pagination structure is not empty.
								paginationLink.closest( '.fw-container' ).find( '.cwpgt-pagination' ).html( data.data.pagination );
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
		$( '.cwpgt-pagination' ).on( 'click', 'a.page-numbers', function( e ) {
			e.preventDefault();

			if ( !isActiveAjax ) {	// If user can use ajax.
				isActiveAjax = true;	// Ajax for other actions is blocked.
				paginationLink = $( this );
				productsTerm = $( '.term.cwpgt_active' ).attr( 'data-term' );	// Get term slug from data-attribute.
				productsPerPage = parseInt( paginationLink.closest( '.cwpgt-pagination' ).attr( 'data-per-page' ) );

				sort = $( '.sort.cwpgt_active' ).attr( 'data-sort' );	// Get sorting type from data-attribute.
				minPrice = $( '.price-sorting__input_min' ).val();
				maxPrice = $( '.price-sorting__input_max' ).val();

				if ( paginationLink.hasClass( 'cwpgt-pagination__previous' ) ) {
					productsCurrentPage = parseInt( paginationLink.closest( '.cwpgt-pagination' ).find( '.page-numbers.current' ).html() ) - 1;
				}	else if ( paginationLink.hasClass( 'cwpgt-pagination__next' ) ) {
					productsCurrentPage = parseInt( paginationLink.closest( '.cwpgt-pagination' ).find( '.page-numbers.current' ).html() ) + 1;
				}	else {
					productsCurrentPage = parseInt( paginationLink.html() );
				}

				// Preloader appears.
				appendPreloader( 'cwpgt-product-more-info-preloader' );

				ajaxData = {
					action 					: '_cwpgt_pagination_number_click',
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
							$( '.cwpgt-product-more-info-preloader' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide preloader.

							// Delay 1 second to play animation, then remove preloader.
							setTimeout(
								function() {
									$( '.cwpgt-product-more-info-preloader' ).remove();	// Remove preloader from DOM.
								},
								1000
							);

							if ( data.data.structure != '' ) {	// If new HTML structure is not empty.
								$( '.term-products-wrapper' ).html( data.data.structure );
							}

							if ( data.data.pagination != '' ) {	// If new pagination structure is not empty.
								$( '.cwpgt-pagination' ).html( data.data.pagination );
							}

							// Scroll to the top of the products list.
							$( 'html, body' ).animate( {
						        scrollTop: $( '.term-products-wrapper' ).offset().top
						    }, 'slow' );

							isActiveAjax = false;	// User can use ajax ahead.
			    			break;

						case false: 	// If we have some errors.
			    			console.log( data.data.message );	// Show errors in console.
			    			$( '.cwpgt-product-more-info-preloader' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide preloader.

							// Delay 1 second to play animation, then remove preloader.
							setTimeout(
								function() {
									$( '.cwpgt-product-more-info-preloader' ).remove();	// Remove preloader from DOM.
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