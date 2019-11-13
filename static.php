<?php
if ( !defined( 'FW' ) ) die( 'Forbidden' );

$uri = fw_get_template_customizations_directory_uri( '/extensions/shortcodes/shortcodes/cwp-get-terms' );
wp_enqueue_style(
    'fw-shortcode-cwp-get-terms',
    $uri . '/static/css/styles.css'
);
wp_enqueue_script(
    'fw-shortcode-cwp-get-terms',
    $uri . '/static/js/scripts.min.js'
);
?>