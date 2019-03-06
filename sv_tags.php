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
		$this->set_module_desc( __( 'This module gives the ability to display and manage tags via the "[sv_tags]" shortcode.', $this->get_module_name() ) );

		// Section Info
		$this->set_section_title( 'Tags' );
		$this->set_section_desc( __( 'Manage Tags', $this->get_module_name() ) );
		$this->set_section_type( 'settings' );
		$this->get_root()->add_section( $this );

		// Loads Settings
		$this->load_settings();

		// Action Hooks
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );

		// Shortcodes
		add_shortcode( $this->get_module_name(), array( $this, 'shortcode' ) );
	}

	public function load_settings() {
		$this->s['limit'] = static::$settings->create($this)
		                                     ->set_ID( 'limit' )
		                                     ->set_title( 'Max number of tags in list.' )
		                                     ->set_description( __( 'You can define the number of tags that should be outputted on the website, by setting a limit.', $this->get_module_name() ) )
		                                     ->load_type( 'number' );
	}

	public function after_setup_theme() {
		load_theme_textdomain( $this->get_module_name(), $this->get_path() . 'languages' );
	}

	private function get_most_popular( $settings ) {
		if ( ! $this->tags ) {
			$this->tags							= get_tags(
				array(
					'pad_counts'				=> true
				)
			);
		}

		if ( ! $this->tags ) {
			return false;
		}

		$counts									= $tag_links = array();

		foreach ( $this->tags as $tag ) {
			$counts[ $tag->name ]				= $tag->count;
			$tag_links[ $tag->name ]			= get_tag_link( $tag->term_id );
		}

		asort( $counts );

		$counts									= array_reverse( $counts, true );
		$i										= 0;

		$output									= '<div class="' . $this->get_prefix( 'wrapper' ) . '">
												<span class="' . $this->get_prefix( 'title' ) . '">Tags:</span>
												<div class="' . $this->get_prefix() . '">';
		$separator                              = ' ';

		foreach ( $counts as $tag => $count ) {
			$i++;
			$tag_link					    	= esc_url( $tag_links[ $tag ] );
			$tag							    = str_replace( ' ', '&nbsp;', esc_html( $tag ) );

			if ( $i <= ( $settings['limit'] ? $settings['limit'] : 3 ) ) {
				$output						    .= '<a href="' . $tag_link . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', $this->get_module_name() ), $tag ) ) . '">' . $tag . '</a>' . $separator;
			}
		}

		$output									.= '</div>';

		return $output;
	}

	public function shortcode( $settings, $content = '' ) {
		// Load Styles
		static::$scripts->create( $this )
		                ->set_path( 'lib/css/frontend.css' );

		$settings								= shortcode_atts(
			array(
				'inline'						=> false,
				'limit'							=> intval( $this->s['limit']->run_type()->get_data() ) ? intval( $this->s['limit']->run_type()->get_data() ) : 5,
			),
			$settings,
			$this->get_module_name()
		);

		return $this->get_most_popular( $settings );
	}
}
