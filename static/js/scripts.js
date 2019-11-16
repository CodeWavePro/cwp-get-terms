jQuery( function( $ ) {

	/**
	 * When all page is loaded.
	 */
	$( document ).ready( function() {
		/**
		 * Product plus click.
		 */
		$( '.cwpgt-product' ).on( 'click', '.product-actions', function( e ) {
			e.preventDefault();
			btn = $( this );
			slide = btn.closest( '.cwpgt-product' );
			clicked = btn.attr( 'data-clicked' );

			if ( clicked == 0 ) {
				// Display current overlay.
				$( this ).addClass( 'product-actions_active' );
				$( '.button-slide-overlay', slide ).css( 'display', 'grid' );

				// Overlays before buttons appearing.
				$( '.button-slide-overlay-before_brand', slide ).addClass( 'button-slide-overlay-before_active' );
				setTimeout( function() {
					$( '.button-slide-overlay-before', slide ).addClass( 'button-slide-overlay-before_active' );
				}, 50 );

				// Current overlay animation on show.
				setTimeout( function() {
					$( '.button-slide-overlay', slide ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );
					$( '.button-slide-overlay .button', slide ).removeClass( 'fadeOutUp' ).addClass( 'fadeInDown' );
					btn.attr( 'data-clicked', 1 );
				}, 1 );
			}	else {	// Close.
				$( this ).removeClass( 'product-actions_active' );
				$( '.button-slide-overlay .button', slide ).removeClass( 'fadeInDown' ).addClass( 'fadeOutUp' );
				$( '.button-slide-overlay', slide ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );

				setTimeout( function() {
					$( '.button-slide-overlay-before', slide ).removeClass( 'button-slide-overlay-before_active' );
				}, 300 );

				setTimeout( function() {
					$( '.button-slide-overlay-before_brand', slide ).removeClass( 'button-slide-overlay-before_active' );
				}, 350 );

				setTimeout( function() {
					$( '.button-slide-overlay', slide ).css( 'display', 'none' );
					btn.attr( 'data-clicked', 0 );
				}, 1000 );
			}
		} );

		/**
		 * Close more info about product.
		 */
		$( '.cwpgt-product' ).on( 'click', '.close-popup', function( e ) {
			e.preventDefault();
			$( '.cwpgt-more-info-wrapper' ).css( 'display', 'none' );
		} );
	} );

} );