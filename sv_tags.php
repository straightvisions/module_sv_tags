<?php
	namespace sv_100;
	
	/**
	 * @author			Matthias Reuter
	 * @package			sv_100
	 * @copyright		2017 Matthias Reuter
	 * @link			https://straightvisions.com
	 * @since			1.0
	 * @license			See license.txt or https://straightvisions.com
	 */
	class sv_tags extends init{
		const section_title							= 'Tags';
		
		static $scripts_loaded						= false;
		private $tags								= false;

		public function __construct($path,$url){
			$this->path								= $path;
			$this->url								= $url;
			$this->name								= get_class($this);
			
			add_shortcode($this->get_module_name(), array($this, 'shortcode'));
			add_action('admin_init', array($this, 'admin_init'));
			add_action('init', array($this, 'init'));
		}
		public function after_setup_theme(){
			load_theme_textdomain( $this->get_module_name(), $this->get_path() . 'languages' );
		}
		public function admin_init(){
			$this->get_root()->add_section($this, 'settings');
			$this->load_settings();
		}
		public function init(){
			if(!is_admin()){
				$this->load_settings();
			}
		}
		public function load_settings(){
			$this->s['limit'] = static::$settings->create($this)
				->set_section_group('Tags')
				->set_section_name('Tags')
				->set_section_description('Manage Tags')
				->set_ID('limit')
				->set_title('Max number of tags in list.')
				->set_description('You can define the number of tags that should be outputted on the website, by setting a limit.')
				->load_type('number');
		}
		private function get_most_popular($settings){
			if(!$this->tags){
				$this->tags							= get_tags(array(
					'pad_counts'					=> true
				));
			}
			
			if(!$this->tags){
				return false;
			}
			
			$counts									= $tag_links = array();
			foreach ( $this->tags as $tag ) {
				$counts[$tag->name]					= $tag->count;
				$tag_links[$tag->name]				= get_tag_link( $tag->term_id );
			}
			asort($counts);
			$counts									= array_reverse( $counts, true );
			$i										= 0;
			
			$output									= '<ul class="'.$this->get_module_name().' mb-4 mx-lg-0"><li class="'.$this->get_module_name().'_first"><strong>'.__('Top Topics', $this->get_module_name()).'</strong></li>';
			foreach ( $counts as $tag => $count ) {
				$i++;
				$tag_link						= esc_url($tag_links[$tag]);
				$tag							= str_replace(' ', '&nbsp;', esc_html( $tag ));
				if($i <= ($settings['limit'] ? $settings['limit'] : 3)){
					$output						.= '<li><a href="'.$tag_link.'">'.$tag.'</a></li>';
				}
			}
			$output									.= '</ul>';
			
			return $output;
		}
		public function shortcode($settings, $content=''){
			$settings								= shortcode_atts(
				array(
					'inline'						=> false,
					'limit'							=> intval($this->s['limit']->run_type()->get_data()) ? intval($this->s['limit']->run_type()->get_data()) : 5,
				),
				$settings,
				$this->get_module_name()
			);
			$this->module_enqueue_scripts($settings['inline']);
			
			return $this->get_most_popular($settings);
		}
	}
