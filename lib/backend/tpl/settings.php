<?php
	if ( current_user_can( 'activate_plugins' ) ) {
		?>
		<div class="sv_section_description"><?php echo $module->get_section_desc(); ?></div>
		<h3 class="divider"><?php _e( 'Tag Settings', 'sv100' ); ?></h3>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_setting( 'limit' )->run_type()->form();
			?>
		</div>
		
		<h3 class="divider"><?php _e( 'Text Settings', 'sv100' ); ?></h3>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_settings_component( 'font_family' )->run_type()->form();
				echo $module->get_settings_component( 'font_size' )->run_type()->form();
				echo $module->get_settings_component( 'line_height' )->run_type()->form();
				echo $module->get_settings_component( 'text_color' )->run_type()->form();
			?>
		</div>

		<h3 class="divider"><?php _e( 'Color Settings', 'sv100' ); ?></h3>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_settings_component( 'bg_color' )->run_type()->form();
				echo $module->get_settings_component( 'highlight_color' )->run_type()->form();
				echo $module->get_setting( 'title_color' )->run_type()->get_data();
			?>
		</div>
		<?php
	}