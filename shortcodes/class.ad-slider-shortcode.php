<?php 

if( !class_exists('AD_Slider_Shortcode') ){
    class AD_Slider_Shortcode {
        public function __construct() {
            add_shortcode('ad_slider', [$this, 'add_shortcode']);
        }

        public function add_shortcode($atts = [], $content = null, $tag = '') {
            $atts = array_change_key_case((array) $atts, CASE_LOWER);

            extract( shortcode_atts(
                [
                    'id'        =>  '',
                    'orderby'   =>  'date'
                ], 
                $atts, 
                $tag
                ) );

                if( !empty( $id ) ) {
                    $id = array_map( 'absint', explode( ',', $id ) );
                }

                ob_start();
                require( AD_SLIDER_PATH . '/views/ad-slider_shortcode.php' );
                wp_enqueue_script('ad-slider-main-js');
                wp_enqueue_script('ad-slider-options-js');
                wp_enqueue_style('ad-slider-main-css');
                wp_enqueue_style('ad-slider-style-css');
                return ob_get_clean();
        }


    }
}