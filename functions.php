<?php 

function pt_custom_styles(){

    wp_enqueue_block_style(
        'core/image',
        array(
            'name'  => 'pt-chatterton',
            'label' => __( 'Chatterton', 'pt' ),
            'style_handle' => 'pt-chatterton',
            'src' => get_template_directory_uri() . '/blocks/core-image/chatterton.css',
        )
    );

    register_block_style(
        'core/image',
        array(
            'name'  => 'chatterton',
            'label' => __( 'Chatterton', 'pt' ),
            'style_handle' => 'pt-chatterton',
        )
    );

}
add_action( 'init', 'pt_custom_styles' );




//enqueue gutenberg.css on both front and back end
function pt_gutenberg_styles() {
    wp_enqueue_style( 'pt-gutenberg', get_template_directory_uri() . '/gutenberg.css', false );
}
add_action( 'enqueue_block_editor_assets', 'pt_gutenberg_styles' );
add_action( 'wp_enqueue_scripts', 'pt_gutenberg_styles' );






// INCLUDE ACF

// Define path and URL to the ACF plugin.
define( 'MY_ACF_PATH', get_stylesheet_directory() . '/includes/acf/' );
define( 'MY_ACF_URL', get_stylesheet_directory_uri() . '/includes/acf/' );

// Include the ACF plugin.
include_once( MY_ACF_PATH . 'acf.php' );

// Customize the URL setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url( $url ) {
    return MY_ACF_URL;
}


function register_acf_blocks() {
	
	// Check function exists.
	if( function_exists('acf_register_block') ) {
		register_block_type( __DIR__ . '/blocks/timetable' );
	}
}

add_action('init', 'register_acf_blocks');

add_action( 'acf/init', function() {
        acf_add_options_page( array(
        'page_title' => 'Horaires',
        'menu_slug' => 'horaires',
        'icon_url' => 'dashicons-clock',
        'position' => '',
        'redirect' => false,
    ) );
} );



