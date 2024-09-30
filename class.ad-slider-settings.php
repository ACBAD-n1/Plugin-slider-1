<?php 

if( !class_exists( 'AD_Slider_Settings' ) ) {
    class AD_Slider_Settings {
        public static $options;

        public function __construct() {
            self::$options = get_option('ad_slider_options');
            add_action( 'admin_init', [ $this, 'admin_init' ] );
        }

        public function admin_init() {

            register_setting('ad_slider_group', 'ad_slider_options', [ $this, 'ad_slider_validate' ]);

            add_settings_section(
                'ad_slider_main_section', 
                'How does it Work', 
                null, 
                'ad_slider_page1'
            );

            add_settings_section(
                'ad_slider_second_section', 
                'Other Plugin Options', 
                null, 
                'ad_slider_page2'
            );

            add_settings_field(
                'ad_slider_shortcode', 
                'Shortcode', 
                [ $this, 'ad_slider_shortcode_callback' ], 
                'ad_slider_page1', 
                'ad_slider_main_section'
            );

            add_settings_field(
                'ad_slider_title', 
                'Slider Title', 
                [ $this, 'ad_slider_title_callback' ], 
                'ad_slider_page2', 
                'ad_slider_second_section',
                [
                    'label_for' =>  'ad_slider_title'
                ]

            );

            add_settings_field(
                'ad_slider_bullets', 
                'Display Bullets', 
                [ $this, 'ad_slider_bullets_callback' ], 
                'ad_slider_page2', 
                'ad_slider_second_section',
                [
                    'label_for' =>  'ad_slider_bullets'
                ]
            );

            add_settings_field(
                'ad_slider_style', 
                'Slider Style', 
                [ $this, 'ad_slider_style_callback' ], 
                'ad_slider_page2', 
                'ad_slider_second_section',
                [
                    'items' =>  [
                        'style-1',
                        'style-2'
                    ],
                    'label_for' =>  'ad_slider_style'

                    ]
            );
        }

        public function ad_slider_shortcode_callback() {
            ?>
            <span>Use The shortcode [ad_slider] to display the slider in any page/post/widget</span>
            <?php 
        }

        public function ad_slider_title_callback( $args ) {
            ?>
                <input 
                type="text" 
                name="ad_slider_options[ad_slider_title]" 
                id="ad_slider_title"
                value="<?php echo isset( self::$options['ad_slider_title'] ) ? esc_attr(self::$options['ad_slider_title']) : ''; ?>"
                >
            <?php 
        }

        public function ad_slider_bullets_callback( $args ) {
            ?>
                <input 
                type="checkbox" 
                name="ad_slider_options[ad_slider_bullets]" 
                id="ad_slider_bullets"
                value="1"
                <?php 
                if( isset(self::$options['ad_slider_bullets']) ) {
                    checked( "1", self::$options['ad_slider_bullets'], true );
                }
                ?>
                >
                <label for="ad_slider_bullets">Whether To Display Bulletes Or Not</label>
            <?php 
        }

        public function ad_slider_style_callback( $args ) {
            ?>
            <select 
            name="ad_slider_options[ad_slider_style]" 
            id="ad_slider_style">
            <?php  
            foreach( $args['items'] as $item ):
            ?>

            <option value="<?php echo esc_attr($item) ?>"
                <?php 
                isset( self::$options['ad_slider_style'] ) ? selected( $item , self::$options['ad_slider_style'], true ) : ''; 
                ?> >
                <?php echo esc_html( ucfirst( $item ) ); ?>
            </option>

            <?php endforeach; ?>
            </select>
            <?php
        }

        public function ad_slider_validate( $input ) {
            $new_input = [];
            foreach( $input as $key => $value ) {
                $new_input[$key]    =  sanitize_text_field( $value );
            }
            return $new_input;
        }

    }
}