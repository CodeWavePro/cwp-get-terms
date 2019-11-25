<?php
if ( !defined( 'FW' ) ) die( 'Forbidden' );

$uri = fw_get_template_customizations_directory_uri( '/extensions/shortcodes/shortcodes/cwp-get-terms' );
wp_enqueue_style(
    'fw-shortcode-cwp-get-terms',
    $uri . '/static/css/styles.css'
);

/**
 * Function localizes js file and makes own variable for ajax-url.
 */
if ( !is_admin() ) {
	$uri = fw_get_template_customizations_directory_uri( '/extensions/shortcodes/shortcodes/cwp-get-terms' );

	if ( wp_script_is( 'cwp-get-terms', 'registered' ) ) {
		return false;
	}	else {
		wp_enqueue_script(
			'cwp-get-terms',
			$uri . '/static/js/scripts.min.js',
			array( 'jquery' )
		);
		wp_localize_script(
			'cwp-get-terms',
			'cwpAjax',
			array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
		);
	}
}
?>