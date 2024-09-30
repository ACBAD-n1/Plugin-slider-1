<?php 

if( !function_exists( 'ad_slider_options' ) ) {
    function ad_slider_options() {
        $show_bullets = isset( AD_Slider_Settings::$options['ad_slider_bullets'] ) && AD_Slider_Settings::$options['ad_slider_bullets'] == 1 ? true : false;

        wp_enqueue_script('ad-slider-options-js', AD_SLIDER_URL . '/vendor/flexslider/flexslider.js', ['jquery'], AD_SLIDER_VERSION, true);
        wp_localize_script('ad-slider-options-js', 'SLIDER_OPTIONS', [
            'controlNav'    =>  $show_bullets
        ]);
    }
}