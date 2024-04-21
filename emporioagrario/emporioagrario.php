<?php
/**
 * Plugin Name:       Emporio Agrario - Main plugin
 * Plugin URI:        https://www.networkvision.it
 * Description:       Main plugin for Emporio Agrario
 * Version:           1.0
 * Requires at least: 5.7
 * Requires PHP:      7.4
 * Author:            Network Vision
 * Author URI:        https://www.networkvision.it
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       emporioagrario-main-plugin
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


define( 'EMPORIOAGRARIO_MAIN_PLUGIN_VERSION', '1.0' );
define( 'EMPORIOAGRARIO_MAIN_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'EMPORIOAGRARIO_MAIN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


// Magento 2
define ('EMPORIO_AGRARIO_MAGENTO2_API_URL', 'https://shop.emporioagrario.it/rest/V1/');
define ('EMPORIO_AGRARIO_MAGENTO2_API_TOKEN', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');


require_once __DIR__ . '/includes/ea-shortcodes.php';


function emporioagrario_scripts() {
    wp_enqueue_style('swiper-css', EMPORIOAGRARIO_MAIN_PLUGIN_URL . 'css/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', EMPORIOAGRARIO_MAIN_PLUGIN_URL . 'js/swiper-bundle.min.js', array(), false, true);

    wp_enqueue_script('emporioagrario-js', EMPORIOAGRARIO_MAIN_PLUGIN_URL . 'js/emporioagrario.js', array(), EMPORIOAGRARIO_MAIN_PLUGIN_VERSION, true);
}
add_action('wp_enqueue_scripts', 'emporioagrario_scripts');



function register_emporio_agrario_shop_carousel_widget( $widgets_manager ) {

    require_once( __DIR__ . '/widgets/emporio-agrario-shop-carousel-widget.php' );

    $widgets_manager->register( new \Emporio_Agrario_Shop_Carousel_Widget() );

}

add_action( 'elementor/widgets/widgets_registered', 'register_emporio_agrario_shop_carousel_widget' );
