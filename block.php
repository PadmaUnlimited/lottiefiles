<?php

class PadmaLottieFilesBlock extends PadmaBlockAPI {
	
	public $id;
	public $name;
	public $options_class;
	public $description;
	public $categories;
	
	function __construct(){

		$this->id 				= 'lottiefiles';	
		$this->name 			= 'Lottie Files';		
		$this->options_class 	= 'PadmaLottieFilesBlockOptions';		
		$this->description 		= 'Display Lottie animations from https://lottiefiles.com/featured';
		$this->categories 		= array('animations','media');

	}

	
	public function init() {
	}
	
	public function setup_elements() {
	}


	public static function dynamic_css($block_id, $block = false) {

		if ( !$block )
			$block = PadmaBlocksData::get_block($block_id);

		$css = 'lottie-player{width: 100%;}';

		return $css;
		
	}

	public static function dynamic_js($block_id, $block = false) {

		if ( !$block )
			$block = PadmaBlocksData::get_block($block_id);

		/*

		debug($block);
		
		$origin = 'path';
		$loop = (isset($block['settings']['loop'])) ? $block['settings']['loop'] : 'true';

		if( isset($block['settings']['source']) && $block['settings']['source'] == 'url' ){
			
			$source = trim($block['settings']['animation-url']);		
		
		}elseif ( isset($block['settings']['source']) && $block['settings']['source'] == 'file' ) {

			$source = trim($block['settings']['animation-file']);
			
		}else{
			$source =  plugin_dir_url( __FILE__ ) . 'json/156-star-blast.json';
		}


		$container = 'svgContainer-' . $block['id'];

		$js = "jQuery(document).ready(function() {";		
		$js .= "var svgContainer = document.getElementById('".$container."');";
		$js .= "var animItem = bodymovin.loadAnimation({";
		$js .= "	wrapper: svgContainer,";
		$js .= "	animType: 'svg',";
		$js .= "	loop: ".$loop.",";
		$js .= "	" . $origin . ": '". $source ."'";
		$js .= "});";
		$js .= "});";

		return $js;*/
		
	}
	
	public function content($block) {

		$origin = 'path';
		
		$loop = ( isset($block['settings']['loop']) ) ? $block['settings']['loop'] : 'loop';
		if( $loop == 'yes' ){
			$loop = 'loop';
		}else{
			$loop = ' ';
		}
		
		$controls = ( isset($block['settings']['controls']) ) ? $block['settings']['controls'] : '';
		$autoplay = ( isset($block['settings']['autoplay']) ) ? $block['settings']['autoplay'] : 'autoplay';
		

		if( isset($block['settings']['source']) && $block['settings']['source'] == 'url' ){
			
			$source = trim($block['settings']['animation-url']);		
		
		}elseif ( isset($block['settings']['source']) && $block['settings']['source'] == 'file' ) {

			$source = trim($block['settings']['animation-file']);
			
		}else{
			$source =  plugin_dir_url( __FILE__ ) . 'json/156-star-blast.json';
		}

		$html = '<lottie-player ';
		$html .= 'src="' . $source . '" ';
		$html .= $loop . ' ';
		$html .= $controls . ' ';
		$html .= $autoplay . ' ';
        //style="width: 400px; --lottie-player-seeker-track-color: #ff3300; --lottie-player-seeker-thumb-color: #ffcc00;"                
      	$html .= '></lottie-player>';
      	echo $html;
	}
	
	public static function enqueue_action($block_id, $block = false) {
		
		if ( !$block )
			$block = PadmaBlocksData::get_block($block_id);
				
		$path = plugin_dir_url( __FILE__ );

		/* JS */		
		wp_enqueue_script( 'padma-lottiefiles', $path . 'js/lottie.min.js', [], false, true );
	}
}

class PadmaLottieFilesBlockOptions extends PadmaBlockOptionsAPI {
	
	public $tabs;
	public $sets;
	public $inputs;

	function __construct(){
		
		$this->tabs = array(
			'general' 			=> 'General',
		);

		$this->sets = array();

		$this->inputs = array(
			'general' => array(

				'source' => array(
					'type' => 'select',
					'name' => 'source',
					'label' => 'Animation Source',
					'default' => 'url',
					'options' => array(
						'' => '',
						'file' => 'File',
						'url' => 'URL',
					),
					'toggle'    => array(
						'file' => array(
							'hide' => array(
								'#input-animation-url'
							),
							'show' => array(
								'#input-animation-file'
							)
						),
						'url' => array(
							'hide' => array(
								'#input-animation-file'
							),
							'show' => array(
								'#input-animation-url'
							)
						),
					)					
				),

				'animation-file' => array(
					'type' => 'json',
					'name' => 'animation-file',
					'label' => 'Animation JSON File',
					'default' => '',					
					'tooltip' => 'Upload the json file',
					'button-label' => __('Select File','padma'),					
				),

				'animation-url' => array(
					'type' => 'text',
					'name' => 'animation-url',
					'label' => 'Animation URL',
					'default' => '',					
					'tooltip' => 'json file URL',
				),

				'loop' => array(
					'type' => 'select',
					'name' => 'loop',
					'label' => 'Loop',
					'default' => 'true',
					'options' => array(
						'yes' => 'Yes',
						'no' => 'No',
					),				
				),

				'controls' => array(
					'type' => 'select',
					'name' => 'controls',
					'label' => 'Controls',
					'default' => 'false',
					'options' => array(
						'true' => 'True',
						'false' => 'False',
					),				
				),

				'autoplay' => array(
					'type' => 'select',
					'name' => 'autoplay',
					'label' => 'Autoplay',
					'default' => 'true',
					'options' => array(
						'true' => 'True',
						'false' => 'False',
					),				
				),
			),
		);
	}


	public function modify_arguments($args = false) {
		$this->tab_notices['general'] = sprintf( __('Get animations from  <a href="%s" target="_blank">lottiefiles.com</a>','padma'), 'https://lottiefiles.com/recent' );
	}
	
}