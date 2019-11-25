jQuery( function( $ ) {
	var isActiveAjax = false;

	/**
	 * When all page is loaded.
	 */
	$( document ).ready( function() {
		var clicked, owl;
		var data; // For Ajax request.
		var moreImagesNewActiveImage;	// New image source link in more product images slider.

		/**
		 * Product plus click.
		 */
		$( '.cwpgt-product' ).on( 'click', '.cwpgt-product-actions', function( e ) {
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
		$( '.cwpgt-product' ).on( 'click', '.cwpgt-more-info-button', function( e ) {
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

				$( 'body' ).append(
					'<div class = "cwpgt-product-more-info-preloader animated fadeIn">' +
						'<i class = "fas fa-spinner cwpgt-product-more-info-preloader__icon"></i>' +
					'</div>'
				);

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
								    	},
								    	500: {
								    	},
								    	800: {
								    	},
								    	1200: {
								    	},
								    	1600: {
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
	} );

} );