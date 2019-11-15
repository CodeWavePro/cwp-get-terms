<?php
if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

// Get terms by taxonomy slug.
$terms = get_terms(
	[
		'taxonomy'		=> 'products',	// Taxonomy slug.
		'hide_empty'	=> true 	// Do not show empty terms.
	]
);
?>

<!-- List of terms from 'products' taxonomy. -->
<ul class = "terms">
	<?php
	// Each term name from 'products' taxonomy outputing in loop.
	foreach ( $terms as $key => $term ) {
		if ( $key === 0 ) {
			echo '<li class = "term term_active">';
		}	else {
			echo '<li class = "term">';
		}

		esc_html_e( $term->name );
		echo '</li>';
	}
	?>
</ul>