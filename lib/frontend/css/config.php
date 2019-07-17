<?php
	// Text Settings
	$font_family				= $script->get_parent()->get_setting( 'font_family' )->run_type()->get_data();
	
	if ( $font_family ) {
		$font					= $script->get_parent()->get_module( 'sv_webfontloader' )->get_font_by_label( $font_family );
	} else {
		$font                     = false;
	}
	
	$font_size					= $script->get_parent()->get_setting( 'font_size' )->run_type()->get_data();
	$text_color					= $script->get_parent()->get_setting( 'text_color' )->run_type()->get_data();
	$line_height				= $script->get_parent()->get_setting( 'line_height' )->run_type()->get_data();
	
	// Color Settings
	$bg_color					= $script->get_parent()->get_setting( 'bg_color' )->run_type()->get_data();
	$highlight_color			= $script->get_parent()->get_setting( 'highlight_color' )->run_type()->get_data();
	$title_color				= $script->get_parent()->get_setting( 'title_color' )->run_type()->get_data();
?>

.sv100_sv_tags,
.sv100_sv_tags .sv100_sv_tags_wrapper a {
	font-family: <?php echo ( $font ? '"' . $font['family'] . '", ' : '' ); ?>sans-serif;
	font-weight: <?php echo ( $font ? $font['weight'] : '400' ); ?>;
	font-size: <?php echo $font_size; ?>px;
	color: <?php echo $text_color; ?>;
	line-height: <?php echo $line_height; ?>px;
}

.sv100_sv_tags .sv100_sv_tags_wrapper a:hover,
.sv100_sv_tags .sv100_sv_tags_wrapper a:focus {
	color: <?php echo $highlight_color; ?>;
}

.sv100_sv_tags .sv100_sv_tags_wrapper a {
	background-color: <?php echo $bg_color; ?>;
}

.sv100_sv_tags .sv100_sv_tags_title {
	color: <?php echo $title_color; ?>;
}