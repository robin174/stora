<?php
/**
* stora functions and definitions
* @link https://developer.wordpress.org/themes/basics/theme-functions/
* @package stora    
*/

error_log("AIRTABLE_API_URL from wp-config.php: " . (defined('AIRTABLE_API_URL') ? AIRTABLE_API_URL : "NOT DEFINED"));

/* TODO: cross-reference with SmilePl and Foundation. */
/* Set container width here? */

/* Store the theme's directory path and uri in constants */
define('THEME_DIR_PATH', get_template_directory());
define('THEME_DIR_URI', get_template_directory_uri());

/* Timestamp css files (works on js too):
https://www.youtube.com/watch?v=kHp_yz3_6rI */

/* Enqueue styles and scripts */
function stora_scripts() {

    // load Bootstrap CSS v5.1
    wp_enqueue_style( 'stora-bootstrap-css', THEME_DIR_URI . '/includes/css/bootstrap.min.css');

    // load website CSS, versioned
    wp_enqueue_style( 'stora-css', THEME_DIR_URI . '/assets/css/style.css', [], filemtime( get_stylesheet_directory() . '/assets/css/style.css') );

	// load Bootstrap JS v5.1
	wp_enqueue_script( 'stora-bootstrap-js', THEME_DIR_URI . '/includes/js/bootstrap.min.js', array('jquery') );
}
add_action( 'wp_enqueue_scripts', 'stora_scripts' );


// ACF Options
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'menu_title'    => 'Additional Settings',
        'menu_slug'     => 'additional-site-settings',
        'parent_slug'   => '',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-admin-site-alt',
        'redirect'      => true
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'General Settings',
        'menu_title'    => 'General Settings',
        'parent_slug'   => 'additional-site-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Footer Content',
        'menu_title'    => 'Footer Content',
        'parent_slug'   => 'additional-site-settings',
    ));
}

/* Register navigation */
function stora_nav() {
    wp_nav_menu( 
        array( 
            'theme_location'    => 'primary',
            'depth'             => 2,
            'menu_id'           => 'primary-menu', 
            'container_class'   => 'ms-auto', 
            'menu_class'        => 'navbar-nav',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback', // check this
            'walker'            => new wp_bootstrap_navwalker(), // check this
        ) 
    );
}

/* Register menus */
if ( ! function_exists( 'stora_setup' ) ) :
	function stora_setup() {

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'stora' ),
        'footer'  => __( 'Footer Menu', 'stora' ),
    ) );

    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    // To make the theme widget aware: https://developer.wordpress.org/themes/functionality/widgets/
}
endif;
add_action( 'after_setup_theme', 'stora_setup');

/* Load custom WordPress nav walker */
require_once THEME_DIR_PATH . '/includes/wp-bootstrap-navwalker5.php';



// Pass Airtable Data to JavaScript Using wp_localize_script
// Instead of fetching directly via JavaScript, let WordPress provide the API URL.
function enqueue_custom_scripts() {
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', [], null, true);
    wp_enqueue_script('drag-modal-script', get_template_directory_uri() . '/js/drag03-modal.js', array('jquery'), time(), true);

    // Pass the correct API URL based on the environment
    wp_localize_script('drag-modal-script', 'wpData', [
        'api_url' => AIRTABLE_API_URL
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Create a Custom API Endpoint for Airtable
function fetch_airtable_data() {
    $response = wp_remote_get("http://localhost:3010/data");

    if (is_wp_error($response)) {
        return new WP_Error('error', 'Failed to fetch Airtable data', ['status' => 500]);
    }

    $body = wp_remote_retrieve_body($response);
    return rest_ensure_response(json_decode($body, true));
}

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/airtable', [
        'methods'  => 'GET',
        'callback' => 'fetch_airtable_data'
    ]);
});