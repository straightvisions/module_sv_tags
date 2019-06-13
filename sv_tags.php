<?php
namespace sv_100;

/**
 * @version         1.00
 * @author			straightvisions GmbH
 * @package			sv_100
 * @copyright		2017 straightvisions GmbH
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */

class sv_tags extends init {
	private $tags								= false;

	public function __construct() {

	}

	public function init() {
		// Module Info
		$this->set_module_title( 'SV Tags' );
		$this->set_module_desc( __( 'This module gives the ability to display and manage tags via the "[sv_tags]" shortcode.', 'sv_100' ) );

		// Section Info
		$this->set_section_title( __( 'Tags', 'sv_100' ) );
		$this->set_section_desc( __( 'Manage Tags', 'sv_100' ) );
		$this->set_section_type( 'settings' );
		$this->get_root()->add_section( $this );

		// Shortcodes
		add_shortcode( $this->get_module_name(), array( $this, 'shortcode' ) );

		$this->load_settings()->register_scripts();
	}

	public function load_settings() :sv_tags {
		$this->s['limit'] = static::$settings
			->create( $this )
			->set_ID( 'limit' )
			->set_title( 'Max number of tags in list.' )
			->set_description( __( 'You can define the number of tags that should be outputted on the website, by setting a limit.', 'sv_100' ) )
			->load_type( 'number' );

		return $this;
	}

	protected function register_scripts() :sv_tags{
		// Register Styles
		$this->scripts_queue['default']        = static::$scripts
			->create( $this )
			->set_ID( 'default' )
			->set_path( 'lib/frontend/css/default.css' )
			->set_inline( true );

		return $this;
	}

	public function shortcode( $settings, $content = '' ) :string {
		$settings								= shortcode_atts(
			array(
				'inline'						=> false,
				'limit'							=> intval( $this->s['limit']->run_type()->get_data() ) ? intval( $this->s['limit']->run_type()->get_data() ) : 5,
			),
			$settings,
			$this->get_module_name()
		);

		return $this->router( $settings );
	}

	// Handles the routing of the templates
	protected function router( array $settings ) :string {
		$template = array(
			'name'      => 'default',
			'scripts'   => array(
				$this->scripts_queue[ 'default' ]->set_inline( $settings['inline'] ),
			),
		);

		return $this->load_template( $template, $settings );
	}

	// Loads the templates
	protected function load_template( array $template, array $settings ) :string {
		ob_start();
		foreach ( $template['scripts'] as $script ) {
			$script->set_is_enqueued();
		}

		// Loads the template
		include ( $this->get_path('lib/frontend/tpl/' . $template['name'] . '.php' ) );
		$output							        = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
