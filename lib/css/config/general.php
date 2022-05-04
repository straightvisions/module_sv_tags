<?php
	echo $_s->build_css(
		'.sv100_sv_tags',
		array_merge(
			$module->get_setting('padding')->get_css_data('padding'),
			$module->get_setting('margin')->get_css_data(),
			$module->get_setting('border')->get_css_data()
		)
	);

	echo $_s->build_css(
		'.sv100_sv_tags .sv100_sv_tags_wrapper a',
		array_merge(
			$module->get_setting('font')->get_css_data('font-family'),
			$module->get_setting('font_size')->get_css_data('font-size','','px'),
			$module->get_setting('line_height')->get_css_data('line-height'),
			$module->get_setting('text_color')->get_css_data(),
			$module->get_setting('bg_color')->get_css_data('background-color')
		)
	);

	echo $_s->build_css(
		'.sv100_sv_tags .sv100_sv_tags_wrapper a:hover,
		.sv100_sv_tags .sv100_sv_tags_wrapper a:focus',
		array_merge(
			$module->get_setting('highlight_color')->get_css_data()
		)
	);

	echo $_s->build_css(
		'.sv100_sv_tags .sv100_sv_tags_title',
		array_merge(
			$module->get_setting('title_color')->get_css_data()
		)
	);