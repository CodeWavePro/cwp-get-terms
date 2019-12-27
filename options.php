<?php if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = [
	'taxonomy_icon'  => [
        'type'          => 'icon-v2',
        'label'         => esc_html__( 'Taxonomy Icon', 'mebel-laim' ),
        'desc'          => esc_html__( 'Please choose icon for taxonomy choice', 'mebel-laim' ),
        'preview_size'  => 'medium',
        'modal_size'    => 'medium'
    ],

    'sorting_icon'  => [
        'type'          => 'icon-v2',
        'label'         => esc_html__( 'Sorting Icon', 'mebel-laim' ),
        'desc'          => esc_html__( 'Please choose icon for sorting type', 'mebel-laim' ),
        'preview_size'  => 'medium',
        'modal_size'    => 'medium'
    ],

    'price_icon'  => [
        'type'          => 'icon-v2',
        'label'         => esc_html__( 'Price Icon', 'mebel-laim' ),
        'desc'          => esc_html__( 'Please choose icon for price', 'mebel-laim' ),
        'preview_size'  => 'medium',
        'modal_size'    => 'medium'
    ],

    'filter_icon'  => [
        'type'          => 'icon-v2',
        'label'         => esc_html__( 'Filter Icon', 'mebel-laim' ),
        'desc'          => esc_html__( 'Please choose icon for filter button', 'mebel-laim' ),
        'preview_size'  => 'medium',
        'modal_size'    => 'medium'
    ],

	'products_per_page'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Products Per Page', 'mebel-laim' ),
		'desc'	=> esc_html__( 'Please enter count of products to be displayed', 'mebel-laim' )
	],

    'specification_icon'  => [
        'type'          => 'icon-v2',
        'label'         => esc_html__( 'Specification Icon', 'mebel-laim' ),
        'desc'          => esc_html__( 'Please choose icon for specification field', 'mebel-laim' ),
        'preview_size'  => 'medium',
        'modal_size'    => 'medium'
    ],

    'currency_icon'  => [
        'type'          => 'icon-v2',
        'label'         => esc_html__( 'Currency Icon', 'mebel-laim' ),
        'desc'          => esc_html__( 'Please choose icon for currency', 'mebel-laim' ),
        'preview_size'  => 'medium',
        'modal_size'    => 'medium'
    ]
];