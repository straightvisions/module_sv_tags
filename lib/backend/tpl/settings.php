<?php
	if ( current_user_can( 'activate_plugins' ) ) {
		?>
		<div class="sv_section_description"><?php echo $module->get_section_desc(); ?></div>
		<h3 class="divider"><?php _e( 'Tags', 'sv100' ); ?></h3>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_setting( 'limit' )->form();
			?>
		</div>
		
		<h3 class="divider"><?php _e( 'Text', 'sv100' ); ?></h3>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_setting( 'font_family' )->form();
				echo $module->get_setting( 'font_size' )->form();
				echo $module->get_setting( 'line_height' )->form();
				echo $module->get_setting( 'text_color' )->form();
			?>
		</div>

		<h3 class="divider"><?php _e( 'Colors', 'sv100' ); ?></h3>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_setting( 'bg_color' )->form();
				echo $module->get_setting( 'highlight_color' )->form();
				echo $module->get_setting( 'title_color' )->form();
			?>
		</div>
		<?php
	}