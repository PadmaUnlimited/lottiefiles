<?php
/*
Plugin Name: Padma LottieFiles
Plugin URI: https://www.padmaunlimited.com/plugins/lottiefiles
Description: Lottie animations
Version: 1.0.6
Author: Padma Unlimited team
Author URI: https://www.padmaunlimited.com
License: GNU GPL v2
*/

add_action('after_setup_theme', function() {

    if ( !class_exists('Padma') )
		return;
	
	if (!class_exists('PadmaBlockAPI') )
		return false;

	if( ! (version_compare( PADMA_VERSION, '1.2.0') >= 0) ){
				
		add_action( 'admin_notices', function() {
		    ?>
		    <div class="notice notice-warning is-dismissible">
		        <p><?php _e( 'Padma LottieFiles requires Padma 1.2.0 or higher.', 'padma-lottiefiles' ); ?></p>
		    </div>
		    <?php
		} );

		return;
		
	}

	$class = 'PadmaLottieFilesBlock';
	$block_type_url = substr(WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), '', plugin_basename(__FILE__)), 0, -1);		
	$class_file = __DIR__ . '/block.php';
	$icons = array(
			'path' => __DIR__,
			'url' => $block_type_url
		);

	padma_register_block(
		$class,
		$block_type_url,
		$class_file,
		$icons
	);



});


add_filter('upload_mimes',function( $mimes ){

	$mimes['json'] = 'application/json';
	return $mimes;

});
add_filter( 'wp_check_filetype_and_ext', function( $types, $file, $filename, $mimes ){
	if( false !== strpos( $filename, '.json' ) ){
        $types['ext'] = 'json';
        $types['type'] = 'text/json';
    }
    return $types;
},10,4);