<?php 
/*
 * Plugin Name:       AD Slider
 * Plugin URI:        https://adamboureima/adplugin
 * Description:       Handle the basics with this plugin.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Adam Boureima
 * Author URI:        https://adamboureima.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       ad-slider
 * Domain Path:       /languages
 */

 if( !defined ('ABSPATH')){
    die('Hi I am a plugin not musch I can do without wordpress is working');
    exit;
 }

 if(! class_exists('AD_Slider')) {
    class AD_Slider{
        function __construct() {
             $this->define_constants();

             require_once(  AD_SLIDER_PATH . '/functions/functions.php');

             add_action( 'admin_menu', [$this, 'add_menu'] );

             require_once(AD_SLIDER_PATH . '/post-types/class.ad-slider-cpt.php');
             $AD_Slider_Post_Type = new AD_Slider_Post_Type();

             require_once(AD_SLIDER_PATH . 'class.ad-slider-settings.php');
             $AD_Slider_Settings = new AD_Slider_Settings();

             require_once(AD_SLIDER_PATH . '/shortcodes/class.ad-slider-shortcode.php');
             $AD_Slider_Shortcode = new AD_Slider_Shortcode();

             add_action( 'wp_enqueue_scripts', [$this, 'register_scripts'], 999 );
             add_action( 'admin_enqueue_scripts', [$this, 'register_admin_scripts'] );
        }

        public function define_constants(){
            define( 'AD_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
            define( 'AD_SLIDER_URL', plugin_dir_url( __FILE__ ) );
            define( 'AD_SLIDER_VERSION', '1.0.0' );
        }

        public static function activate() {
            update_option('rewrite_rules', '');
        }

        public static function deactivate() {
            flush_rewrite_rules();
            unregister_post_type('ad-slider');
        }

        public static function uninstall() {

        }

        public function add_menu() {
            add_menu_page( 
                'AD Slider Options', 
                'AD Slider', 
                'manage_options', 
                'ad_slider_admin', 
                [$this, 'ad_slider_settings_page'], 
                'dashicons-slides', 
            );

            add_submenu_page(
                'ad_slider_admin', 
                'Manage Slides', 
                'Manage Slides', 
                'manage_options', 
                'edit.php?post_type=ad-slider', 
                null,
                null
            );

            add_submenu_page(
                'ad_slider_admin', 
                'Add New Slide', 
                'Add New Slide', 
                'manage_options', 
                'post-new.php?post_type=ad-slider', 
                null,
                null
            );
        }

        public function ad_slider_settings_page() {
            if( !current_user_can('manage_options') ) {
                return;
            }
            if( isset( $_GET['settings-updated'] ) ) {
                add_settings_error('ad_slider_options', 'ad_slider_message', 'Settings Saved', 'success');
            }
            settings_errors('ad_slider_options');

            require( AD_SLIDER_PATH . '/views/settings-page.php' );
        }

        public function register_scripts() {
            wp_register_script('ad-slider-main-js', AD_SLIDER_URL . '/vendor/flexslider/jquery.flexslider-min.js', ['jquery'], AD_SLIDER_VERSION, true);
            wp_register_script('ad-slider-options-js', AD_SLIDER_URL . '/vendor/flexslider/flexslider.js', ['jquery'], AD_SLIDER_VERSION, true);

            wp_register_style('ad-slider-main-css', AD_SLIDER_URL . '/vendor/flexslider/flexslider.css', [], AD_SLIDER_VERSION, 'all' );
            wp_register_style('ad-slider-style-css', AD_SLIDER_URL . '/assets/css/frontend.css', [], AD_SLIDER_VERSION, 'all' );
        }

        public function register_admin_scripts() {
            global $typenow;
            if( $typenow == 'ad-slider' ) {
                wp_enqueue_style( 'ad-slider-admin', AD_SLIDER_URL . '/assets/css/admin.css' );
            }
        }

    }
 }

 if(class_exists('AD_Slider')) {
   register_activation_hook(__FILE__, ['AD_Slider', 'activate']);
   register_deactivation_hook(__FILE__, ['AD_Slider', 'deactivate']);
   register_uninstall_hook(__FILE__, ['AD_Slider', 'uninstall']);

    $ad_slider = new AD_Slider();
 }