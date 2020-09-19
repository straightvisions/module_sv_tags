<?php

	echo $_s->build_css(
		'.sv100_sv_tags .sv100_sv_tags_wrapper a',
		array_merge(
			$script->get_parent()->get_setting('font')->get_css_data('font-family'),
			$script->get_parent()->get_setting('font_size')->get_css_data('font-size','','px'),
			$script->get_parent()->get_setting('line_height')->get_css_data('line-height'),
			$script->get_parent()->get_setting('text_color')->get_css_data(),
			$script->get_parent()->get_setting('bg_color')->get_css_data('background-color')
		)
	);

	echo $_s->build_css(
		'.sv100_sv_tags .sv100_sv_tags_wrapper a:hover,
		.sv100_sv_tags .sv100_sv_tags_wrapper a:focus',
		array_merge(
			$script->get_parent()->get_setting('highlight_color')->get_css_data()
		)
	);

	echo $_s->build_css(
		'.sv100_sv_tags .sv100_sv_tags_title',
		array_merge(
			$script->get_parent()->get_setting('title_color')->get_css_data()
		)
	);