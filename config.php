<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'			=> esc_html__( 'CWP Get Terms', 'mebel-laim' ),
	'description'	=> esc_html__( 'Add list of all your terms.', 'mebel-laim' ),
	'tab'			=> esc_html__( 'Content Elements', 'mebel-laim' ),
	'icon' 			=> 'dashicons dashicons-editor-ul'
);