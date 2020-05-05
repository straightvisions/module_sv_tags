<?php
	// Fetches all settings and creates new variables with the setting ID as name and setting data as value.
	// This reduces the lines of code for the needed setting values.
	foreach ( $script->get_parent()->get_settings() as $setting ) {
		${ $setting->get_ID() } = $setting->get_data();

		// If setting is color, it gets the value in the RGB-Format
		if ( $setting->get_type() === 'setting_color' ) {
			${ $setting->get_ID() } = $setting->get_rgb( ${ $setting->get_ID() } );
		}
	}

	// Text Settings
	if ( $font_family ) {
		$font					= $script->get_parent()->get_module( 'sv_webfontloader' )->get_font_by_label( $font_family );
	} else {
		$font                     = false;
	}
?>

.sv100_sv_tags,
.sv100_sv_tags .sv100_sv_tags_wrapper a {
	font-family: <?php echo ( $font ? '"' . $font['family'] . '", ' : '' ); ?>sans-serif;
	font-weight: <?php echo ( $font ? $font['weight'] : '400' ); ?>;
	font-size: <?php echo $font_size; ?>px;
	color: rgba(<?php echo $text_color; ?>);
	line-height: <?php echo $line_height; ?>px;
}

.sv100_sv_tags .sv100_sv_tags_wrapper a:hover,
.sv100_sv_tags .sv100_sv_tags_wrapper a:focus {
	color: rgba(<?php echo $highlight_color; ?>);
}

.sv100_sv_tags .sv100_sv_tags_wrapper a {
	background-color: rgba(<?php echo $bg_color; ?>);
}

.sv100_sv_tags .sv100_sv_tags_title {
	color: rgba(<?php echo $title_color; ?>);
}