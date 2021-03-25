<?php
	namespace sv100;

	class sv_tags extends init {
		public function init() {
			$this->set_module_title( __( 'SV Tags', 'sv100' ) )
				 ->set_module_desc( __( 'Manages tags.', 'sv100' ) )
				->set_css_cache_active()
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_template_path()
				->set_section_order(3800)
				->set_section_icon('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9.776 2l11.395 11.395-7.78 7.777-11.391-11.391v-7.781h7.776zm.829-2h-10.605v10.609l13.391 13.391 10.609-10.604-13.395-13.396zm-3.191 7.414c-.781.782-2.046.782-2.829.001-.781-.783-.781-2.048 0-2.829.782-.782 2.048-.781 2.829-.001.782.783.781 2.047 0 2.829z"/></svg>')
				->get_root()
				->add_section( $this );
		}
	
		public function load_settings(): sv_tags
		{
			$this->get_setting('limit')
				->set_title(__('Max number of tags in list.', 'sv100'))
				->set_description(
					__('You can define the max number of tags that should be displayed, by setting a limit.', 'sv100')
				)
				->set_default_value(3)
				->load_type('number');

			// Text Settings
			$this->get_setting('font')
				->set_title(__('Font Family', 'sv100'))
				->set_description(__('Choose a font for your text.', 'sv100'))
				->set_options($this->get_module('sv_webfontloader') ? $this->get_module('sv_webfontloader')->get_font_options() : array('' => __('Please activate module SV Webfontloader for this Feature.', 'sv100')))
				->set_is_responsive(true)
				->load_type('select');

			$this->get_setting('font_size')
				->set_title(__('Font Size', 'sv100'))
				->set_description(__('Font Size in pixel.', 'sv100'))
				->set_default_value(14)
				->set_is_responsive(true)
				->load_type('number');

			$this->get_setting('line_height')
				->set_title(__('Line Height', 'sv100'))
				->set_description(__('Set line height as multiplier or with a unit.', 'sv100'))
				->set_is_responsive(true)
				->load_type('text');

			$this->get_setting('text_color')
				->set_title(__('Text Color', 'sv100'))
				->set_default_value('#828282')
				->set_is_responsive(true)
				->load_type('color');

			// Color Settings
			$this->get_setting('bg_color')
				->set_title(__('Background Color', 'sv100'))
				->set_default_value('#f5f5f5')
				->set_is_responsive(true)
				->load_type('color');

			$this->get_setting('highlight_color')
				->set_title(__('Highlight Color', 'sv100'))
				->set_description(__('This color is used for highlighting elements, like links on hover/focus.', 'sv100'))
				->set_default_value('#328ce6')
				->set_is_responsive(true)
				->load_type('color');

			$this->get_setting('title_color')
				->set_title(__('Title color', 'sv100'))
				->set_default_value('#828282')
				->set_is_responsive(true)
				->load_type('color');

			return $this;
		}
		public function load( $settings = array() ): string {
			if(!is_admin()){
				$this->load_settings()->register_scripts();

				foreach($this->get_scripts() as $script){
					$script->set_is_enqueued();
				}
			}

			$settings			= shortcode_atts(
				array(
					'inline'	=> false,
					'limit'		=> intval( $this->get_setting( 'limit' )->get_data() )
						? intval($this->get_setting( 'limit' )->get_data() )
						: 5,
				),
				$settings,
				$this->get_module_name()
			);

			// Loads the template
			ob_start();
			require ( $this->get_path('lib/tpl/frontend/default.php' ) );
			$output									= ob_get_clean();

			return $output;
		}
	}
