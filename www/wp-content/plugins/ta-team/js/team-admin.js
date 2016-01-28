jQuery(document).ready(function ($) {
	var $showcaseMetaBox = $( '#team-showcase-options' ),
		$displayField = $showcaseMetaBox.find( 'tr#showcase-display-option' ),
		$display = $displayField.find( 'select' ),
		$customFields = $displayField.nextAll().hide();

	$display.on( 'change', function() {
		if ( 'custom' == $display.val() ) {
			$customFields.show();
		} else {
			$customFields.hide();
		}
	} ).trigger( 'change' );
});
