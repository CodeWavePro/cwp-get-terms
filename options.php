<?php if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'products_per_page'	=> array(
		'type'	=> 'text',
		'label'	=> esc_html__( 'Products Per Page', 'mebel-laim' ),
		'desc'	=> esc_html__( 'Please enter count of products to be displayed', 'mebel-laim' )
	)
);