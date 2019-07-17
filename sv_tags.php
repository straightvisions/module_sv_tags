<?php
	namespace sv100;
	
	/**
	 * @version         4.000
	 * @author			straightvisions GmbH
	 * @package			sv100
	 * @copyright		2019 straightvisions GmbH
	 * @link			https://straightvisions.com
	 * @since			1.000
	 * @license			See license.txt or https://straightvisions.com
	 */
	
	class sv_tags extends init {
		private $tags								= false;
	
		public function init() {
			// Module Info
			$this->set_module_title( 'SV Tags' );
			$this->set_module_desc( __( 'This module gives the ability to display tags in posts.', 'sv100' ) );
	
			// Section Info
			$this->set_section_title( __( 'Tags', 'sv100' ) )
				 ->set_section_desc( __( 'Manage Tags', 'sv100' ) )
				 ->set_section_type( 'settings' )
				 ->set_section_template_path( $this->get_path( 'lib/backend/tpl/settings.php' ) );
			
			$this->get_root()->add_section( $this );
	
			$this->load_settings()->register_scripts();
		}
	
		public function load_settings(): sv_tags {
			$this->s['limit'] =
				$this->get_setting()
					 ->set_ID( 'limit' )
					 ->set_title( __( 'Max number of tags in list.', 'sv100' ) )
					 ->set_description( __( 'You can define the number of tags that should be outputted on the website, by setting a limit.', 'sv100' ) )
					 ->load_type( 'number' );
			
			// Text Settings
			$this->get_settings_component( 'font_family','font_family' );
			$this->get_settings_component( 'font_size','font_size', 14 );
			$this->get_settings_component( 'text_color','text_color', '#85868c' );
			$this->get_settings_component( 'line_height','line_height', 21 );
			
			// Color Settings
			$this->s['title_color'] =
				$this->get_setting()
					 ->set_ID( 'title_color' )
					 ->set_title( __( 'Title Color', 'sv100' ) )
					 ->set_default_value( '#85868c' )
					 ->load_type( 'color' );
			$this->get_settings_component( 'bg_color','background_color', '#f7f7f7' );
			$this->get_settings_component( 'highlight_color','highlight_color', '#358ae9' );
	
			return $this;
		}
	
		protected function register_scripts(): sv_tags{
			// Register Styles
			$this->scripts_queue['default'] =
				static::$scripts
					->create( $this )
					->set_ID( 'default' )
					->set_path( 'lib/frontend/css/default.css' )
					->set_inline( true );
			
			$this->scripts_queue['inline_config'] =
				static::$scripts->create( $this )
								->set_ID( 'inline_config' )
								->set_path( 'lib/frontend/css/config.php' )
								->set_inline( true );
	
			return $this;
		}
	
		public function load( $settings = array() ): string {
			$settings			= shortcode_atts(
				array(
					'inline'	=> false,
					'limit'		=> intval( $this->get_setting( 'limit' )->run_type()->get_data() )
						? intval($this->get_setting( 'limit' )->run_type()->get_data() )
						: 5,
				),
				$settings,
				$this->get_module_name()
			);
	
			return $this->router( $settings );
		}
	
		// Handles the routing of the templates
		protected function router( array $settings ): string {
			$template = array(
				'name'      => 'default',
				'scripts'   => array(
					$this->scripts_queue[ 'default' ]->set_inline( $settings['inline'] ),
				),
			);
	
			return $this->load_template( $template, $settings );
		}
	
		// Loads the templates
		protected function load_template( array $template, array $settings ): string {
			ob_start();
			
			foreach ( $template['scripts'] as $script ) {
				$script->set_is_enqueued();
			}
			
			$this->scripts_queue['inline_config']->set_is_enqueued();
	
			// Loads the template
			include ( $this->get_path('lib/frontend/tpl/' . $template['name'] . '.php' ) );
			$output							        = ob_get_contents();
			ob_end_clean();
	
			return $output;
		}
	}
